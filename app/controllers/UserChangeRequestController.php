<?php

class UserChangeRequestController extends \BaseController {

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
            ['user' => $user,
             'req' => Auth::user(),
             'branches' => Branch::getBranchList(),
             'chapters' => Chapter::getChapters(null, 0, false),
             'billets'  => ['0' => 'Select a Billet'] + Billet::getBillets(),
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
        if (empty($data['req_id']) === false && $data['user_id'] !== $data['req_id']) {
            $requestor = User::find($data['req_id']);
        } else {
            $requestor = $user;
        }

        // A form submission may have multiple change requests, but each change request gets it's own record in the
        // database

        $record = [
            'user' => $user->id,
            'requestor' => $requestor->id
        ];

        // Branch Change

        if (empty($data['branch']) === false) {
            $record['req_type'] = 'branch';
            $record['old_value'] = $data['old_branch'];
            $record['new_value'] = $data['branch'];

            ChangeRequest::create($record);
        }

        if (empty($data['primary_billet']) === false) {
            $record['req_type'] = 'assignment.billet';
            $record['old_value'] = $data['old_billet'];
            $record['new_value'] = $data['primary_billet'];

            ChangeRequest::create($record);
        }

        if (empty( $data['primary_assignment'] ) === false) {
            $record['req_type'] = 'assignment.chapter';
            $record['old_value'] = $data['old_assignment'];
            $record['new_value'] = $data['primary_assignment'];

            ChangeRequest::create($record);
        }

        return Redirect::route('home')->with(
            'message',
            'Your change request has been sent to BuPers for review.  You will be notified via email once the request has been processed.'
        );

	}

	/**
	 * Display the specified resource.
	 * GET /userchangerequest/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /userchangerequest/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /userchangerequest/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /userchangerequest/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function review()
    {
        $records = ChangeRequest::all();
        foreach ($records as $index => $record) {
            $records[$index]['user'] = User::find($record['user']);
            $records[$index]['requestor'] = User::find($record['requestor']);
            if ($record['req_type'] === 'assignment.chapter') {
                $records[$index]['old_chapter'] = Chapter::where('_id', '=', $record['old_value'])->first()->chapter_name;
                $records[$index]['new_chapter'] = Chapter::where('_id', '=', $record['new_value'])->first()->chapter_name;
            }
        }

        return View::make('user.requests.review', ['records' => $records]);
    }

}