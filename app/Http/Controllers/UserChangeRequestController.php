<?php

namespace App\Http\Controllers;

use App\User;
use App\Grade;
use App\Branch;
use App\Chapter;
use App\ChangeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class UserChangeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /userchangerequest.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /userchangerequest/create.
     *
     * @return Response
     */
    public function create(\App\User $user)
    {
        return view(
            'user.requests.index',
            [
                'user' => $user,
                'req' => Auth::user(),
                'branches' => Branch::getBranchList(),
                'chapters' => Chapter::getFullChapterList(false),
                'allchapters' => Chapter::getChapters(null, 0, false),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * POST /userchangerequest.
     *
     * @return Response
     */
    public function store()
    {
        $data = Request::all();

        $user = User::find($data['user_id']);
        if (empty($data['req_id']) === false && $data['user_id'] !== $data['req_id']) {
            $requestor = User::find($data['req_id']);
        } else {
            $requestor = $user;
        }

        // A form submission may have multiple change requests, but each change request gets it's own record in the
        // database

        $record = [
            'user' => $user->id,
            'requestor' => $requestor->id,
            'status' => 'open',
        ];

        // Branch Change

        if (empty($data['new_branch']) === false) {
            $record['req_type'] = 'branch';
            $record['old_value'] = $data['old_branch'];
            $record['new_value'] = $data['new_branch'];

            $this->writeAuditTrail(
                (string) Auth::user()->_id,
                'create',
                'change_request',
                null,
                json_encode($record),
                'UserChangeRequestController@store'
            );

            ChangeRequest::create($record);
        }

        if (empty($data['primary_billet']) === false) {
            $record['req_type'] = 'assignment.billet';
            $record['old_value'] = $data['old_billet'];
            $record['new_value'] = $data['primary_billet'];

            $this->writeAuditTrail(
                (string) Auth::user()->_id,
                'create',
                'change_request',
                null,
                json_encode($record),
                'UserChangeRequestController@store'
            );

            ChangeRequest::create($record);
        }

        if (empty($data['primary_assignment']) === false) {
            $record['req_type'] = 'assignment.chapter';
            $record['old_value'] = $data['old_assignment'];
            $record['new_value'] = $data['primary_assignment'];

            $this->writeAuditTrail(
                (string) Auth::user()->_id,
                'create',
                'change_request',
                null,
                json_encode($record),
                'UserChangeRequestController@store'
            );

            ChangeRequest::create($record);
        }

        return Redirect::route('home')->with(
            'message',
            'Your change request has been sent to BuPers for review.  You will be notified via email once the request has been processed.'
        );
    }

    public function review()
    {
        if (($redirect = $this->checkPermissions('PROC_XFERS')) !== true) {
            return $redirect;
        }

        $records = ChangeRequest::all();

        foreach ($records as $index => $record) {
            $records[$index]['user'] = User::find($record['user']);
            $records[$index]['requestor'] = User::find($record['requestor']);
            if ($record['req_type'] === 'assignment.chapter') {
                if (empty($record['old_value']) === true) {
                    $records[$index]['old_chapter'] = 'Unknown';
                } else {
                    $records[$index]['old_chapter'] =
                        Chapter::where('_id', '=', $record['old_value'])->first()->chapter_name;
                }

                $records[$index]['new_chapter'] =
                    Chapter::where('_id', '=', $record['new_value'])->first()->chapter_name;
            }
        }

        return view('user.requests.review', ['records' => $records]);
    }

    public function approve(ChangeRequest $request)
    {
        if (($redirect = $this->checkPermissions('PROC_XFERS')) !== true) {
            return $redirect;
        }

        /** @var User $user */
        $user = User::find($request->user);
        $message = '';

        switch ($request->req_type) {
            case 'branch':
                $greeting = $user->getGreeting();

                $oldBranchId = $request->old_value;
                $newBranchId = $request->new_value;

                /** @var Branch $oldBranch */
                $oldBranch = Branch::where('branch', $oldBranchId)->first();
                /** @var Branch $newBranch */
                $newBranch = Branch::where('branch', $newBranchId)->first();

                $newRank = Grade::getNewPayGrade($user, $oldBranch, $newBranch);
                $user = User::find($user->id); // User may have been updated, reload the object just in case

                if ($user->branch == $oldBranchId) {
                    $user->branch = $newBranchId;
                }

                $email = 'emails.branch-change';
                $subject = 'Your branch transfer request has been approved';
                $fromValue = $oldBranchId;
                $toValue = $newBranchId;

                $cc[] = $this->getCoEmailForTransferReq(Chapter::find($user->getAssignedShip()));

                $events[] = 'Transferred from '.$oldBranch->branch_name.' to '.
                    $newBranch->branch_name.' on '.date('d M Y');

                break;
            case 'assignment.chapter':
                $assignments = $user->assignment;
                /** @var Chapter $oldChapter */
                $oldChapter = Chapter::find($request->old_value);

                /** @var Chapter $newChapter */
                $newChapter = Chapter::find($request->new_value);

                $cc[] = $this->getCoEmailForTransferReq($oldChapter);
                $cc[] = $this->getCoEmailForTransferReq($newChapter);

                foreach ($assignments as $key => $assignment) {
                    if ($assignment['chapter_id'] == $oldChapter->id) {
                        $assignments[$key]['chapter_id'] = $newChapter->id;
                        $assignments[$key]['chapter_name'] = $newChapter->chapter_name;
                        $assignments[$key]['date_assigned'] = date('Y-m-d');
                    }
                }
                $user->assignment = $assignments;

                $email = 'emails.chapter-change';
                $subject = 'Your chapter transfer request has been approved';
                $fromValue = $oldChapter->chapter_name;
                $toValue = $newChapter->chapter_name;

                $events[] = 'Primary assignment changed to '.$newChapter->chapter_name.' on '.date('d M Y');

                break;
        }

        if (isset($newRank) === true) {
            $oldRank = $user->rank['grade'];

            $user->rank = [
                'date_of_rank' => $user->rank['date_of_rank'],
                'grade' => $newRank,
            ];

            $events[] = 'Rank changed from '.Grade::getRankTitle($oldRank, null, $oldBranchId).' ('.$oldRank.') to '.
                Grade::getRankTitle($newRank, null, $newBranchId).' ('.$newRank.') on '.date('d M Y');
        }

        if (empty($message) === false) {
            $message = '<ul>'.$message.'</ul>';
        }
        // Update the user
        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'update',
            'users',
            $user->id,
            $user->toJson(),
            'UserChangeRequestController@approve'
        );

        $user->save();

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'soft delete',
            'change_request',
            $request->id,
            $request->toJson(),
            'UserChangeRequestController@approve'
        );

        $request->delete();

        // Update the service history

        foreach ($events as $event) {
            $user->addServiceHistoryEntry(['timestamp' => time(), 'event' => $event]);
        }

        // Send the email

        if ($user->branch == 'RMMC') {
            $cc[] = 'comforcecom@rmmc.trmn.org';
        }

        // Send approved email
        Mail::send(
            $email,
            ['user' => $user, 'fromValue' => $fromValue, 'toValue' => $toValue],
            function ($message) use ($user, $cc, $subject) {
                $message->from('bupers@trmn.org', 'TRMN Bureau of Personnel');

                $message->to($user->email_address);

                foreach ($cc as $address) {
                    $message->cc($address);
                }

                $message->subject($subject);
            }
        );

        return Redirect::route('user.change.review')->with('message', $message);
    }

    private function getCoEmailForTransferReq(Chapter $chapter)
    {
        switch ($chapter->chapter_type) {
            // Is this a MARDET?
            case 'shuttle':
            case 'section':
            case 'squad':
            case 'platoon':
            case 'battalion':
                // We have a MARDET, get the parent chapter CO's email address.
                /** @var Chapter $parent */
                $parent = Chapter::find($chapter->assigned_to);
                return $parent->getCO()->email_address;
                break;
            default:
                // Everything else
                try {
                    return $chapter->getCO()->email_address;
                } catch (\Exception $exception) {
                    return null;
                }
        }
    }

    public function deny(ChangeRequest $request)
    {
        if (($redirect = $this->checkPermissions('PROC_XFERS')) !== true) {
            return $redirect;
        }

        $user = User::find($request->user);

        switch ($request->req_type) {
            case 'branch':
                $oldValue = $request->old_value;
                $newValue = $request->new_value;
                $type = 'Branch';
                break;

            case 'assignment.chapter':
                $oldValue = Chapter::find($request->old_value)->chapter_name;
                $newValue = Chapter::find($request->new_value)->chapter_name;
                $type = 'Chapter';
                break;
        }

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'soft delete',
            'change_request',
            $request->id,
            $request->toJson(),
            'UserChangeRequestController@approve'
        );

        $request->delete();

        // Send denied email
        Mail::send(
            'emails.change-denied',
            [
                'user' => $user,
                'type' => $type,
                'fromValue' => $oldValue,
                'toValue' => $newValue,
            ],
            function ($message) use ($user, $type) {
                $message->from('bupers@trmn.org', 'TRMN Bureau of Personnel');

                $message->to($user->email_address)->cc('bupers@trmn.org');

                $message->subject('Your '.strtolower($type).' change request has been denied');
            }
        );

        return Redirect::route('user.change.review');
    }
}
