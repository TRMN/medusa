<?php

namespace App\Http\Controllers;

use App\Ptitles;
use App\User;
use App\Award;
use App\Chapter;
use App\Message;
use App\ImportLog;
use App\UploadLog;
use App\Log\MedusaLog;
use Illuminate\Support\Facades\Event;
use League\Csv\Reader;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UploadController extends Controller
{
    use MedusaLog;

    private $suffixes = [
        "JR",
        "SR",
        "II",
        "III",
        "IV",
        "V"
    ];

    /**
     * Show the Admin page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdmin()
    {
        if (($redirect = $this->checkPermissions('CONFIG')) !== true) {
            return $redirect;
        }

        return view(
            'upload.admin',
            [
                'logs' => UploadLog::all(),
            ]
        );
    }

    /**
     * Show either the status page for the users assigned ship or the specified ship.
     *
     * @param null $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getStatus($id = null)
    {
        if ($this->hasDutyRosterForAssignedShip() === false) {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }

        if (empty($id) === true) {
            // They got this far, we know they have the duty roster for this chapter
            // Get the chapter ID of their assigned ship

            $assignedShip = Auth::user()->getAssignedShip();
        } else {
            $assignedShip = $id;
        }

        // Get the upload log for this chapter, if any
        $log = UploadLog::getEntryByChapterId($assignedShip);

        return view(
            'upload.status',
            [
                'chapter_name' => Chapter::find($assignedShip)->chapter_name,
                'log' => $log,
                'chapter_id' => $assignedShip,
            ]
        );
    }

    /**
     * Show the Promotion Points CSV upload/import page using the generic blade
     * template.
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getPoints($id, $filename)
    {
        if (($redirect = $this->checkPermissions('CONFIG')) !== true) {
            return $redirect;
        }

        return view(
            'upload.index',
            [
                'title' => 'Import Promotion Points',
                'method' => 'previewPoints',
                'source' => '/upload/points',
                'accept' => 'text/csv,*.csv',
                'hidden' => [
                    'logID' => $id,
                    'filename' => $filename,
                ],
            ]
        );
    }

    public function getCzech()
    {
        if (($redirect = $this->checkPermissions('CONFIG')) !== true) {
            return $redirect;
        }

        return view(
            'upload.index',
            [
                'title' => 'Import Czech Members',
                'method' => 'previewPoints',
                'source' => '/upload/points',
                'accept' => 'text/csv,*.csv',
                'hidden' => [
                    'lookupRMN' => TRUE,
                ],
            ]
        );
    }

    /**
     * Show the Promotion Point Spreadsheet upload page.
     *
     * @param $chapter
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getSheet($chapter)
    {
        if ($this->hasDutyRosterForAssignedShip() === false) {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }

        return view(
            'upload.index',
            [
                'title' => 'Upload Chapter Promotion Point Spreadsheet for ' .
                    $chapter->chapter_name,
                'note' => 'Processing the uploaded Promotion Point Spreadsheet is not an automated process.  A BuComm staff member will download your Promotion Point Spreadsheet, parse it on-line and then upload it for processing.  You will be able to check the status of this process by clicking on the &qoute;Promotion Point Status&qoute; button on your roster.',
                'method' => 'processSheet',
                'source' => '/upload/sheet/' . $chapter->id,
                'accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,*.xls,*.xlsx',
                'hidden' => [
                    'chapter' => $chapter->id,
                    'chaptername' => $chapter->chapter_name,
                ],
            ]
        );
    }

    /**
     * Handle the file upload.  This is a generic handler.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool|\Illuminate\Http\RedirectResponse|mixed
     */
    public function postFile(Request $request)
    {
        if (Auth::user()->isCoAssignedShip() === false &&
            Auth::user()->hasAllPermissions() === false) {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }

        // If the file is valid, pass the request on to the specified target method
        if ($request->file('file')->isValid() === true) {
            return call_user_func_array(
                [$this, $request->input('method')],
                [$request]
            );
        } else {
            return redirect($request->source)->with(
                'error',
                'There was an issue with the file you uploaded.  Please try again.'
            );
        }
    }

    /**
     * Locate an existing Upload log entry or create it.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    private function findOrCreateLog(Request $request)
    {
        return UploadLog::firstOrCreate(
            ['chapter_id' => $request->chapter],
            ['chapter_name' => $request->chaptername]
        );
    }

    /**
     * Process the uplaoded promotion points spreadsheet.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function processSheet(Request $request)
    {
        $log = $this->findOrCreateLog($request);

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $numFiles = empty($log->files) === false ? count($log->files) : 0;

        $slug = Str::slug($request->chaptername, '_');
        $filename = $slug . '_' . ($numFiles + 1) . '.' . $ext;

        if ($log->isDuplicate($originalFileName) === false) {
            try {
                // Save the file
                $file->storeAs($slug, $filename, 'points');

                $log->addNewFile(
                    $filename,
                    UploadLog::UPLOAD_STATUS_UPLOADED,
                    $originalFileName
                );

                return redirect($request->source)->with(
                    'message',
                    $originalFileName .
                    ' has been upload.  You may upload additional files if needed.'
                );
            } catch (\Exception $e) {
                return redirect($request->source)->with(
                    'error',
                    'There was an issue with the file you uploaded.  Please try again.'
                );
            }
        } else {
            return redirect($request->source)->with(
                'error',
                'That file has already been uploaded.'
            );
        }
    }

    /**
     * Generate a preview of the import and allow for the import to be cancelled.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function previewPoints(Request $request)
    {
        $lookupRMN = false;

        if ($request->lookupRMN == true) {
            $lookupRMN = true;
            $log = null;
            $filename = $slug = Str::uuid()->toString();
        } else {
            $log = UploadLog::find($request->logID);
            $slug = Str::slug($log['chapter_name'], '_');
            $filename = $request->filename;
        }

        $fileinfo = pathinfo($filename);

        $file = $request->file('file');
        $file->storeAs($slug, $fileinfo['filename'] . '.csv', 'points');

        $import = Reader::createFromPath(
            storage_path(
                'app/points/' . $slug . '/' . $fileinfo['filename'] . '.csv'
            ),
            'r'
        );

        $preview = [];

        // First line of the file is the column header
        $import->setHeaderOffset(0);

        // Get the columns header so we will get back an associative array
        $header = $import->getHeader();

        // Parse each record
        foreach ($import->getRecords($header) as $index => $record) {
            $name = null;

            if (is_null($log) && $lookupRMN == true) {
                // This is a new member import, create a log entry
                $chapterName = $record['chapter'];
                $chapterId = Chapter::getIdByName(trim($chapterName));

                $request->merge(['chapter' => $chapterId, 'chaptername' => $chapterName]);
                $log = $this->findOrCreateLog($request);
            }

            if ($lookupRMN == true) {
                $memberStatus = $this->lookUpRMN($record);
            } else {
                // Try and retrieve the user by their RMN number.
                try {
                    $member = User::getUserByMemberId($record['RMN']);
                    $name = $member->getFullName();
                } catch (ModelNotFoundException $e) {
                    $name = '<span class="red">' . $record['RMN'] . ': Invalid</span>';
                }
            }

            if ($name == null) {
                if (isset($record['Name'])) {
                    $name = '<span class="red">' . $record['Name'] . ': not in database, will be added!</span>';
                } else {
                    $name = '<span class="red">Unknown</span>';
                }
            }

            $row = [
                'name' => $name,
                'chapter' => $record['chapter'],
            ];

            if ($lookupRMN === true) {
                $row['status'] = $memberStatus['status'];
            }

            $preview[] = $row;
        }

        return view(
            'upload.preview',
            [
                'log' => $log,
                'csv' => 'app/points/' . $slug . '/' .
                    $fileinfo['filename'] . '.csv',
                'preview' => $preview,
                'filename' => $filename,
                'lookupRMN' => $lookupRMN,
            ]
        );
    }

    /**
     * Read in the csv file and update the members record as appropriate.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function postProcesspoints(Request $request)
    {
        $this->clearLog('import_points');

        $this->logMsg(
            [
                'source' => 'import_points',
                'severity' => 'info',
                'msg' => 'Promotion point import started ' .
                    date('F j, Y @ g:i a'),
            ]
        );

        // Open the csv file

        $import = Reader::createFromPath(storage_path($request->csv), 'r');

        // First line of the file is the column header
        $import->setHeaderOffset(0);

        // Get the columns header so we will get back an associative array
        $header = $import->getHeader();

        // Parse each record
        foreach ($import->getRecords($header) as $index => $record) {
            $memberFound = false;
            if ($request->lookupRMN == true) {
                list($firstName, $lastName) = explode(' ', $record['Name']);
                $lookup = $this->lookUpRMN($record);

                if ($lookup['record'] instanceof User) {
                    // We have a member.  Update their personal info as needed.
                    $memberFound = true;

                    $member = $lookup['record'];
                    $matchType = $lookup['status'];

                    // If the first name doesn't match, update the member record to match the spreadsheet
                    $member->first_name = trim($member->first_name) !== trim($firstName) ? trim($firstName) :
                        trim($member->first_name);

                    if ($matchType == 'email') {
                        // Found by email address, check if the last name matches.  If it doesn't, update it.
                        $member->last_name = trim($member->last_name) !== trim($lastName) ? trim($lastName) :
                            trim($member->last_name);
                    } else {
                        // Unable to locate member by email address, but got a hit on last name + the first 2
                        // letters of their first name. Update the email address.
                        $member->email_address = trim($member->email_address) !== trim($record['email']) ?
                            trim($record['email']) : trim($member->email_address);
                    }

                    $member->save();
                } else {
                    // Need to add the user
                    // chapter,Name,email,rank,billet,Service,JoinDate,RankDate,path,peerage,lands
                    $name = explode(' ', $record['Name']);
                    $joinDate = date('Y-m-d', strtotime($record['JoinDate']));
                    $rankDate = date('Y-m-d', strtotime($record['RankDate']));

                    $data = [];

                    $data['first_name'] = trim($name[0]);
                    $data['last_name'] = trim($name[1]);
                    $data['email_address'] = trim($record['email']);
                    $data['lastUpdate'] = time();
                    $data['application_date'] = $joinDate;
                    $data['registration_date'] = $joinDate;
                    $data['rank'] = [
                        'grade' => trim($record['rank']),
                        'date_of_rank' => $rankDate,
                    ];
                    $data['ptitle'] = trim($record['peerage']);

                    $chapter = Chapter::where('chapter_name', '=', $record['chapter'])->first();

                    $assignment = [];
                    $history = [];

                    foreach (['primary', 'secondary', 'additional', 'extra'] as $position) {
                        $assignment[] = [
                            'chapter_id' => $chapter->id,
                            'chapter_name' => $chapter->chapter_name,
                            'date_assigned' => $joinDate,
                            'billet' => $record['billet'],
                            $position => true,
                        ];

                        $history[] = [
                            'timestamp' => strtotime($joinDate),
                            'event' => 'Assigned to ' .
                                $chapter->chapter_name . ' as ' .
                                $record['billet'] . ' on ' . date(
                                    'd M Y',
                                    strtotime($joinDate)
                                ),
                        ];
                    }

                    $history = array_values(
                        Arr::sort(
                            $history,
                            function ($value) {
                                return $value['timestamp'];
                            }
                        )
                    );

                    $data['history'] = $history;

                    $data['assignment'] = $assignment;

                    if ($record['Service'] == 'Diplomatic Corps') {
                        $data['branch'] = 'CIVIL';
                        $data['rating'] = 'DIPLOMATIC';
                    } else {
                        $data['branch'] = $record['Service'];
                    }

                    $data['member_id'] =
                        'RMN' . User::getFirstAvailableMemberId(empty($data['honorary']));

                    $data['active'] = 1;
                    $data['registration_status'] = 'Active';
                    $data['path'] = $record['path'];

                    $data['password'] = Hash::make(substr(str_shuffle(MD5(microtime())), 0, 10));

                    // Standard User Permissions
                    $data['permissions'] = [
                        'LOGOUT',
                        'CHANGE_PWD',
                        'EDIT_SELF',
                        'ROSTER',
                        'TRANSFER',
                    ];

                    if (!empty($data['ptitle'])) {
                        $pTitleInfo = Ptitles::where('title', '=', $data['ptitle'])->first();
                        $peerage = [
                            'title' => $record['peerage'],
                            'code' => $pTitleInfo->code,
                            'generation' => 'First',
                            'peerage_id' => uniqid(null, true),
                            'precedence' => $pTitleInfo->precedence,
                            'courtesy' => false,
                            'lands' => $record['lands'],
                        ];
                        $data['peerages'] = [$peerage];
                    }

                    $member = User::create($data);

                    // Strange hack copied from UserController's store method
                    $u = User::find($member['id']);

                    foreach ($data as $key => $value) {
                        $u->$key = $value;
                    }

                    $u->save();

                    Event::dispatch('user.created', $member);
                }
            } else {
                // Instantiate a user model
                $member = User::getUserByMemberId($record['RMN']);
            }

            try {
                // Iterate through the columns
                foreach ($record as $key => $value) {
                    switch ($key) {
                        // Informational fields, ignore them
                        case 'RMN':
                        case 'JoinDate':
                        case 'RankDate':
                        case 'Name':
                        case 'email':
                        case 'rank':
                        case 'billet':
                        case 'Service':
                        case 'chapter':
                            break;
                        // Career Path
                        case 'path':
                            $member->setPath($value);
                            break;
                        // Activity points
                        case 'triad':
                        case 'fleet':
                        case 'ah':
                            // Import is number of 3 month blocks, MEDUSA uses total months
                            $value = $value * 3;
                            $member->setPromotionPointValue($key, $value);
                            break;
                        case 'cpm':
                        case 'cpe':
                        case 'che':
                        case 'cph':
                        case 'chh':
                        case 'vch':
                        case 'con':
                        case 'ahcon':
                        case 'vcon':
                        case 'vahcon':
                        case 'mp':
                        case 'sh':
                        case 'ls':
                        case 'peerage':
                            $member->setPromotionPointValue($key, $value);
                            break;
                        // Anything else is an award
                        default:
                            if ($value > 0) {
                                $award = Award::getAwardByCode($key);
                                if (empty($award)) {
                                    break;
                                }
                                $member->addUpdateAward(
                                    [$key => [
                                        'count' => $value,
                                        'location' => $award['location'],
                                        'award_date' => array_fill(0, $value, '1970-01-01'),
                                        'display' => true,
                                    ],
                                    ]
                                );
                            }
                    }
                }

                $this->localLogMsg(
                    [
                        'source' => 'import_points',
                        'severity' => 'info',
                        'msg' => 'Imported ' . $member->getFullName() . ' (' .
                            $member->member_id . ') of the ' .
                            $record['chapter'] . ' at ' .
                            date('F j, Y @ g:i a'),
                    ]
                );
            } catch (\MongoException $e) {
                $this->localLogMsg(
                    [
                        'source' => 'import_points',
                        'severity' => 'info',
                        'msg' => 'Promblem Importing ' .
                            $member->getFullName() .
                            ' (' .
                            $member->member_id . ') of the ' .
                            $record['chapter'] . ' at ' .
                            date('F j, Y @ g:i a'),
                    ]
                );
            }
        }

        $this->logMsg(
            [
                'source' => 'import_points',
                'severity' => 'info',
                'msg' => 'Promotion point import ended ' .
                    date('F j, Y @ g:i a'),
            ]
        );

        UploadLog::find($request->logId)->updateLog(
            $request->filename,
            UploadLog::UPLOAD_STATUS_IMPORTED
        );

        return view(
            'upload.results',
            [
                'title' => 'Promotion point import results',
                'results' => Message::where('source', 'import_points')->get(),
                'logID' => $request->logID,
                'filename' => $request->filename,
            ]
        );
    }

    /**
     * Log status to both the temporary log as well as the permanent.
     *
     * @param array $msgDetails
     *
     * @throws \MongoException
     */
    private function localLogMsg(array $msgDetails)
    {
        try {
            $this->logMsg($msgDetails);
            ImportLog::create(
                ['source' => $msgDetails['source'],
                    'msg' => $msgDetails['msg'],
                ]
            );
        } catch (\MongoException $e) {
            throw new \MongoException($e->getMessage());
        }
    }

    private function parseName(string $name)
    {
        $names = explode(' ', $name);

        $firstName = $names[0];

        $middleName = $suffix = null;

        if (count($names) > 2) {
            // Either have First Middle Last or First Last Suffix

            if (in_array(strtoupper($names[2]), $this->suffixes)) {
                $lastName = $names[1];
                $suffix = $names[2];
            } else {
                $middleName = $names[1];
                $lastName = $names[2];
            }
        } else {
            $lastName = $names[1];
        }

        $returnObj = new class {
            public $firstName;
            public $middleName;
            public $lastName;
            public $suffix;
        };

        $returnObj->firstName = $firstName;
        $returnObj->middleName = $middleName;
        $returnObj->lastName = $lastName;
        $returnObj->suffix = $suffix;

        return $returnObj;
    }

    private function lookUpRMN(array $record)
    {
        $names = explode(' ', $record['Name']);

        $firstName = $names[0];
        $lastName = $names[1];

        if (count($names) > 2) {
            // Either have First Middle Last or First Last Suffix

            if (in_array(strtoupper($names[2]), $this->suffixes)) {
                $lastName = $names[1];
            } else {
                $lastName = $names[2];
            }
        }

        // Check to see if there is already a member record
        $memberStatus = $results = null;

        if ($results = User::findByEmail(trim($record['email']))) {
            $memberStatus = 'email';
        } elseif ($results = User::findByName($firstName, $lastName)) {
            $memberStatus = 'name';
        }

        if (!($results instanceof User)) {
            $results = null;
        }

        return [
            'status' => $memberStatus,
            'record' => $results
        ];
    }
}
