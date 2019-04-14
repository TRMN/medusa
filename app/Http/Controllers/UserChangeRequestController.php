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
                'user'        => $user,
                'req'         => Auth::user(),
                'branches'    => Branch::getBranchList(),
                'chapters'    => Chapter::getFullChapterList(false),
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
            'user'      => $user->id,
            'requestor' => $requestor->id,
            'status'    => 'open',
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

        $user = User::find($request->user);
        $checkRank = false;
        $message = '';

        switch ($request->req_type) {
            case 'branch':
                $greeting = $user->getGreeting();

                if ($user->branch == $request->old_value) {
                    $user->branch = $request->new_value;
                }

                $email = 'emails.branch-change';
                $subject = 'Your branch transfer request has been approved';

                // CO's email
                $co = Chapter::find($user->getAssignedShip())->getCO();

                if (empty($co) === false) {
                    $cc = [$co->email_address];
                } else {
                    $cc = [];
                }

                $oldValue = $request->old_value;
                $newValue = $request->new_value;

                $checkRank = true;

                $events[] = 'Transferred from '.Branch::getBranchName($oldValue).' to '.Branch::getBranchName($newValue).' on '.date('d M Y');

                break;
            case 'assignment.chapter':
                $assignments = $user->assignment;

                // Old CO's email
                $cc = [Chapter::find($user->getAssignedShip())->getCO()->email_address];

                // Is this a MARDET?
                switch (Chapter::find($user->getAssignedShip())->chapter_type) {
                    case 'shuttle':
                    case 'section':
                    case 'squad':
                    case 'platoon':
                    case 'battalion':
                        // We have a MARDET, get the parent chapter CO's email address.
                        $cc[] = Chapter::find(Chapter::find($user->getAssignedShip())->assigned_to)->getCO()->email_address;
                        break;
                }

                foreach ($assignments as $key => $assignment) {
                    if ($assignment['chapter_id'] == $request->old_value) {
                        $assignments[$key]['chapter_id'] = $request->new_value;
                        $assignments[$key]['chapter_name'] = Chapter::find($request->new_value)->chapter_name;
                        $assignments[$key]['date_assigned'] = date('Y-m-d');
                    }
                }
                $user->assignment = $assignments;

                $email = 'emails.chapter-change';
                $subject = 'Your chapter transfer request has been approved';

                $oldValue = Chapter::find($request->old_value)->chapter_name;
                $newValue = Chapter::find($request->new_value)->chapter_name;

                // New CO's email
                $newChapterCO = Chapter::find($request->new_value)->getCO();

                if (empty($newChapterCO) === false) {
                    $cc[] = $newChapterCO->email_address;
                }

                // Is this a MARDET?
                switch (Chapter::find($request->new_value)->chapter_type) {
                    case 'shuttle':
                    case 'section':
                    case 'squad':
                    case 'platoon':
                    case 'battalion':
                        // We have a MARDET, get the parent chapter CO's email address.
                        $cc[] = Chapter::find(Chapter::find($request->new_value)->assigned_to)->getCO()->email_address;
                        break;
                }

                $events[] = 'Primary assignment changed to '.$newValue.' on '.date('d M Y');

                break;
        }

        if ($checkRank === true) {
            // Get Branch info for the original branch
            $branchInfo = Branch::where('branch', '=', $oldValue)->first();

            // Check for situations that require a members record to be checked

            if ($oldValue == 'RMN' && in_array($newValue, ['RMMC', 'RMA', 'GSN', 'RHN', 'IAN']) === true) {
                $message = '<li>This was a transfer from the RMN to another military branch.  Please check '.$greeting.' '.$user->first_name.' '.$user->last_name."'s record to ensure that their new rank is correct.</li>";
            }

            if ($newValue == 'RMN' && in_array($oldValue, ['RMMC', 'RMA', 'GSN', 'RHN', 'IAN']) === true) {
                $message = '<li>This was a transfer from another military branch to the RMN.  Please check '.$greeting.' '.$user->first_name.' '.$user->last_name."'s record to ensure that their new rank is correct.</li>";
            }

            if (in_array($oldValue, ['RMMC', 'RMA', 'GSN', 'RHN', 'IAN']) === true && in_array(
                $newValue,
                ['CIVIL', 'INTEL', 'SFS', 'RMMM', 'RMASC']
            ) === true) {
                $message = '<li>This was a transfer from a military branch to a civilian branch.  Please check '.$greeting.' '.$user->first_name.' '.$user->last_name."'s record to ensure that their new rank is correct.</li>";
            }

            if (in_array($newValue, ['RMMC', 'RMA', 'GSN', 'RHN', 'IAN']) === true && in_array(
                $oldValue,
                ['CIVIL', 'INTEL', 'SFS', 'RMMM', 'RMASC']
            ) === true) {
                $message = '<li>This was a transfer from a civilian branch to a military branch.  Please check '.$greeting.' '.$user->first_name.' '.$user->last_name."'s record to ensure that their new rank is correct.</li>";
            }

            // SFS notice

            if ($newValue == 'SFS') {
                $message .= '<li>This was a transfer to the Sphinx Forestry Service.  Please check '.$greeting.' '.$user->first_name.' '.$user->last_name."'s age to ensure that their new rank is appropriate for their age.</li>";
            }

            // Look up the equivalent rank

            $oldRank = $user->rank['grade'];
            $newRank = $branchInfo->equivalent[$newValue][$user->rank['grade']];

            // Now check for instances where the equiv rank is E-1/C-1 and the original rank is not E-1/C-1

            switch ($newRank) {
                case 'C-1':
                case 'E-1':
                    if (in_array($user->rank['grade'], ['E-1', 'C-1']) === false) {
                        $message .= '<li>There was no direct equivalent rank found. Please check '.$greeting.' '.$user->first_name.' '.$user->last_name."'s record to ensure that their new rank is correct.</li>";
                    }
                    break;
                default:
            }

            $rank = $user->rank;
            $rank['grade'] = $newRank;
            $user->rank = $rank;

            $events[] = 'Rank changed from '.Grade::getRankTitle(
                $oldRank,
                null,
                $oldValue
            ).' ('.$oldRank.') to '.Grade::getRankTitle(
                $newRank,
                null,
                $newValue
            ).' ('.$newRank.') on '.date('d M Y');
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
            ['user' => $user, 'fromValue' => $oldValue, 'toValue' => $newValue],
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
                'user'      => $user,
                'type'      => $type,
                'fromValue' => $oldValue,
                'toValue'   => $newValue,
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
