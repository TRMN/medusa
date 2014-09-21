<?php

class ChapterController extends \BaseController {

    /**
     * Display a listing of chapters
     *
     * @return Response
     */
    public function index()
    {
        $chapters = Chapter::all();

        return View::make( 'chapter.index', compact( 'chapters' ) );
    }

    /**
     * Show the form for creating a new chapter
     *
     * @return Response
     */
    public function create()
    {
        return View::make( 'chapter.create' );
    }

    /**
     * Store a newly created chapter in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make( $data = Input::all(), Chapter::$rules );

        if ( $validator->fails() )
        {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        Chapter::create( $data );

        return Redirect::route( 'chapter.index' );
    }

    /**
     * Display the specified chapter.
     *
     * @param  int  $id
     * @return Response
     */
    public function show( $id )
    {
        $chapter = Chapter::findOrFail( $id );

        return View::make( 'chapter.show', compact( 'chapter' ) );
    }

    /**
     * Show the form for editing the specified chapter.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit( $id )
    {
        $chapter = Chapter::find( $id );

        return View::make( 'chapter.edit', compact( 'chapter' ) );
    }

    /**
     * Update the specified chapter in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update( $id )
    {
        $chapter = Chapter::findOrFail( $id );

        $validator = Validator::make( $data = Input::all(), Chapter::$rules );

        if ( $validator->fails() )
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $chapter->update( $data );

        return Redirect::route( 'chapter.index' );
    }

    /**
     * Remove the specified chapter from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy( $id )
    {
        Chapter::destroy( $id );

        return Redirect::route( 'chapter.index' );
    }

    /**
     * Add the specified member to the chapter's roster.
     *
     * @param  int  $userId
     * @param  int  $chapterId
     * @return Response
     */
    public function addMember( $userId, $chapterId )
    {
        $chapter = Chapter::findOrFail( $chapterId );
        $user = User::findOrFail( $userId );

        $chapter->members()->attach( $userId );

        return Redirect::route( 'chapter.show', [ 'chapter' => $chapter->id ]);
    }

    /**
     * Remove the specified member from the chapter's roster.
     *
     * @param  int  $userId
     * @param  int  $chapterId
     * @return Response
     */
    public function removeMember( $userId, $chapterId )
    {
        $chapter = Chapter::findOrFail( $chapterId );
        $user = User::findOrFail( $userId );

        $chapter->members()->detach( $userId );

        return Redirect::route( 'chapter.show', [ 'chapter' => $chapter->id ]);
    }

}
