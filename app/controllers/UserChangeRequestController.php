<?php

class UserChangeRequestController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /userchangerequest
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /userchangerequest/create
     *
     * @return Response
     */
    public function create(User $user)
    {
        return View::make(
            "user.requests.index",
            [
                'user'      => $user,
                'req'       => Auth::user(),
                'branches'  => Branch::getBranchList(),
                'chapters'  => Chapter::getChapters(null, 0, false),
                'billets'   => ['0' => 'Select a Billet'] + Billet::getBillets(),
                'locations' => ['0' => 'Select a Location'] + Chapter::getChapterLocations(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * POST /userchangerequest
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();

        $user = User::find($data['user_id']);
        if (empty( $data['req_id'] ) === false && $data['user_id'] !== $data['req_id']) {
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

        if (empty( $data['branch'] ) === false) {
            $record['req_type'] = 'branch';
            $record['old_value'] = $data['old_branch'];
            $record['new_value'] = $data['branch'];

            $this->writeAuditTrail(
                (string)Auth::user()->_id,
                'create',
                'change_request',
                null,
                json_encode($record),
                'UserChangeRequestController@store'
            );

            ChangeRequest::create($record);
        }

        if (empty( $data['primary_billet'] ) === false) {
            $record['req_type'] = 'assignment.billet';
            $record['old_value'] = $data['old_billet'];
            $record['new_value'] = $data['primary_billet'];

            $this->writeAuditTrail(
                (string)Auth::user()->_id,
                'create',
                'change_request',
                null,
                json_encode($record),
                'UserChangeRequestController@store'
            );

            ChangeRequest::create($record);
        }

        if (empty( $data['primary_assignment'] ) === false) {
            $record['req_type'] = 'assignment.chapter';
            $record['old_value'] = $data['old_assignment'];
            $record['new_value'] = $data['primary_assignment'];

            $this->writeAuditTrail(
                (string)Auth::user()->_id,
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
        $records = ChangeRequest::all();

        foreach ($records as $index => $record) {
            $records[$index]['user'] = User::find($record['user']);
            $records[$index]['requestor'] = User::find($record['requestor']);
            if ($record['req_type'] === 'assignment.chapter') {
                $records[$index]['old_chapter'] =
                    Chapter::where('_id', '=', $record['old_value'])->first()->chapter_name;
                $records[$index]['new_chapter'] =
                    Chapter::where('_id', '=', $record['new_value'])->first()->chapter_name;
            }
        }

        return View::make('user.requests.review', ['records' => $records]);
    }

    public function approve(ChangeRequest $request)
    {
        $user = User::find($request->user);

        switch ($request->req_type) {
            case 'branch':
                if ($user->branch == $request->old_value) {
                    $user->branch = $request->new_value;
                }

                $email = 'emails.branch-change';
                $subject = 'Your branch transfer request has been approved';

                // CO's email
                $co = Chapter::find($user->getPrimaryAssignmentId())->getCO();

                if (empty($co) === false) {
                    $cc = [$co->email_address];
                }


                $oldValue = $request->old_value;
                $newValue = $request->new_value;

                break;
            case 'assignment.chapter':
                $assignments = $user->assignment;

                // Old CO's email
                $cc = [Chapter::find($user->getPrimaryAssignmentId())->getCO()->email_address];

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
                $cc[] = Chapter::find($user->getPrimaryAssignmentId())->getCO()->email_address;

                break;
        }

        // Update the user
        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'update',
            'users',
            $user->id,
            $user->toJson(),
            'UserChangeRequestController@approve'
        );

        $user->save();

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'soft delete',
            'change_request',
            $request->id,
            $request->toJson(),
            'UserChangeRequestController@approve'
        );

        $request->delete();

        // Send the email

        if ($user->branch == "RMMC") {
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

        return Redirect::route('user.change.review');
    }

    public function deny(ChangeRequest $request)
    {
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
            (string)Auth::user()->_id,
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
            ['user' => $user,
             'type' => $type, 'fromValue' => $oldValue, 'toValue' => $newValue],
            function ($message) use ($user, $type) {
                $message->from('bupers@trmn.org', 'TRMN Bureau of Personnel');

                $message->to($user->email_address)->cc('bupers@trmn.org');

                $message->subject('Your ' . strtolower($type) . ' change request has been denied');
            }
        );

        return Redirect::route('user.change.review');
    }

}