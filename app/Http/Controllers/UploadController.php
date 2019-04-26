<?php

namespace App\Http\Controllers;

use App\User;
use App\Award;
use App\Chapter;
use App\Message;
use App\ImportLog;
use App\UploadLog;
use App\Log\MedusaLog;
use League\Csv\Reader;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UploadController extends Controller
{
    use MedusaLog;

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
                'log'          => $log,
                'chapter_id'   => $assignedShip,
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
                'title'  => 'Import Promotion Points',
                'method' => 'previewPoints',
                'source' => '/upload/points',
                'accept' => 'text/csv,*.csv',
                'hidden' => [
                    'logID'    => $id,
                    'filename' => $filename,
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
                'title'  => 'Upload Chapter Promotion Point Spreadsheet for '.
                            $chapter->chapter_name,
                'note'   => 'Processing the uploaded Promotion Point Spreadsheet is not an automated process.  A BuComm staff member will download your Promotion Point Spreadsheet, parse it on-line and then upload it for processing.  You will be able to check the status of this process by clicking on the &qoute;Promotion Point Status&qoute; button on your roster.',
                'method' => 'processSheet',
                'source' => '/upload/sheet/'.$chapter->id,
                'accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,*.xls,*.xlsx',
                'hidden' => [
                    'chapter'     => $chapter->id,
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
     * Process the uplaoded promotion points spreadsheet.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function processSheet(Request $request)
    {
        $log = UploadLog::firstOrCreate(
            ['chapter_id' => $request->chapter],
            ['chapter_name' => $request->chaptername]
        );

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $numFiles = empty($log->files) === false ? count($log->files) : 0;

        $slug = Str::slug($request->chaptername, '_');
        $filename = $slug.'_'.($numFiles + 1).'.'.$ext;

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
                    $originalFileName.
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
        $log = UploadLog::find($request->logID);
        $filename = $request->filename;

        $fileinfo = pathinfo($filename);

        $slug = Str::slug($log['chapter_name'], '_');

        $file = $request->file('file');
        $file->storeAs($slug, $fileinfo['filename'].'.csv', 'points');

        $import = Reader::createFromPath(
            storage_path(
                'app/points/'.$slug.'/'.$fileinfo['filename'].'.csv'
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
            // Try and retrieve the user by their RMN number.
            try {
                $member = User::getUserByMemberId($record['RMN']);
                $name = $member->getFullName();
            } catch (ModelNotFoundException $e) {
                $name = '<span class="red">'.$record['RMN'].' : Invalid</span>';
            }

            $preview[] = [
                'name'    => $name,
                'chapter' => $record['chapter'],
            ];
        }

        return view(
            'upload.preview',
            [
                'log'      => $log,
                'csv'      => 'app/points/'.$slug.'/'.
                              $fileinfo['filename'].'.csv',
                'preview'  => $preview,
                'filename' => $filename,
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
                'source'   => 'import_points',
                'severity' => 'info',
                'msg'      => 'Promotion point import started '.
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
            // Instantiate a user model
            $member = User::getUserByMemberId($record['RMN']);

            try {
                // Iterate through the columns
                foreach ($record as $key => $value) {
                    switch ($key) {
                        // Informational fields, ignore them
                        case 'RMN':
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
                                $member->addUpdateAward(
                                    [$key => [
                                             'count'      => $value,
                                             'location'   => Award::getAwardByCode($key)['location'],
                                             'award_date' => array_fill(0, $value, '1970-01-01'),
                                             'display'    => true,
                                         ],
                                    ]
                                );
                            }
                    }
                }

                $this->localLogMsg(
                    [
                        'source'   => 'import_points',
                        'severity' => 'info',
                        'msg'      => 'Imported '.$member->getFullName().' ('.
                                      $member->member_id.') of the '.
                                      $record['chapter'].' at '.
                                      date('F j, Y @ g:i a'),
                    ]
                );
            } catch (\MongoException $e) {
                $this->localLogMsg(
                    [
                        'source'   => 'import_points',
                        'severity' => 'info',
                        'msg'      => 'Promblem Importing '.
                                      $member->getFullName().
                                      ' ('.
                                      $member->member_id.') of the '.
                                      $record['chapter'].' at '.
                                      date('F j, Y @ g:i a'),
                    ]
                );
            }
        }

        $this->logMsg(
            [
                'source'   => 'import_points',
                'severity' => 'info',
                'msg'      => 'Promotion point import ended '.
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
                'title'    => 'Promotion point import results',
                'results'  => Message::where('source', 'import_points')->get(),
                'logID'    => $request->logID,
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
                 'msg'    => $msgDetails['msg'],
                ]
            );
        } catch (\MongoException $e) {
            throw new \MongoException($e->getMessage());
        }
    }
}
