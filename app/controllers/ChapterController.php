<?php

/**
 * Created by PhpStorm.
 * User: dweiner
 * Date: 9/27/14
 * Time: 10:08 PM
 */
class ChapterController extends BaseController
{

    public function index()
    {
        $chapters = Chapter::orderBy( 'chapter_type' )->orderBy( 'chapter_name' )->get();

        for ( $i = 0; $i < count( $chapters ); $i++ ) {
            $chapters[ $i ]->chapter_type = ucfirst( $chapters[ $i ]->chapter_type );
        }

        return View::make( 'chapter.index', [ 'chapters' => $chapters ] );
    }

    public function show( $chapterID )
    {
        $chapter = Chapter::find( $chapterID );

        if ( isset( $chapter->assigned_to ) ) {
            $parentChapter = Chapter::find( $chapter->assigned_to );
        } else {
            $parentChapter = false;
        }

        $includes = Chapter::where( 'assigned_to', '=', $chapter->_id )->get();

        $commandCrew = $chapter->getCommandCrew();

        $crew = $chapter->getCrew();

        return View::make( 'chapter.show', [ 'detail' => $chapter, 'higher' => $parentChapter, 'includes' => $includes, 'command' => $commandCrew, 'crew' => $crew ] );
    }

    /**
     * Show the form for creating a new chapter
     *
     * @return Response
     */
    public function create()
    {
        $types = Type::orderBy('chapter_description')->get(['chapter_type', 'chapter_description']);
        $chapterTypes = [ ];

        foreach ( $types as $chapterType ) {
            $chapterTypes[ $chapterType->chapter_type ] = $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select a Chapter Type'] + $chapterTypes;

        $chapters = Chapter::orderBy( 'chapter_type' )->orderBy( 'chapter_name' )->get( [ '_id', 'chapter_name' ] );

        $chapterList[ '' ] = "N/A";

        foreach ( $chapters as $chapter ) {
            $chapterList[ $chapter->_id ] = $chapter->chapter_name;
        }

        return View::make( 'chapter.create', [ 'chapterTypes' => $chapterTypes, 'chapter' => new Chapter, 'chapterList' => $chapterList ] );
    }

    public function edit( $chapterID )
    {

        $detail = Chapter::find( $chapterID );
        $types = Type::all();
        $chapterTypes = [ ];

        foreach ( $types as $chapterType ) {
            $chapterTypes[ $chapterType->chapter_type ] = $chapterType->chapter_description;
        }

        $chapters = Chapter::orderBy( 'chapter_type' )->orderBy( 'chapter_name' )->get( [ '_id', 'chapter_name' ] );

        $chapterList[ '' ] = "N/A";

        foreach ( $chapters as $chapter ) {
            $chapterList[ $chapter->_id ] = $chapter->chapter_name;
        }

        return View::make( 'chapter.edit', [ 'chapterTypes' => $chapterTypes, 'chapter' => $detail, 'chapterList' => $chapterList ] );
    }

    public function update( $chapterId )
    {

        $validator = Validator::make( $data = Input::all(), Chapter::$updateRules );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        unset( $data[ '_method' ], $data[ '_token' ] );

        $chapter = Chapter::find( $chapterId );

        foreach ( $data as $k => $v ) {
            if ( empty( $data[ $k ] ) === true ) {
                unset( $data[ $k ] );
            } else {
                $chapter->$k = $v;
            }
        }

        $chapter->update( $data );

        return Redirect::route( 'chapter.index' );
    }

    /**
     * Save a newly created chapter
     *
     * @return Responsedb.
     */
    public function store()
    {
        $validator = Validator::make( $data = Input::all(), Chapter::$rules );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        foreach ( $data as $k => $v ) {
            if ( empty( $data[ $k ] ) === true ) {
                unset( $data[ $k ] );
            }
        }

        Chapter::create( $data );

        return Redirect::route( 'chapter.index' );
    }

    /**
     * Remove the specified Chapter.
     *
     * @param  $chapterID
     * @return Response
     */
    public function destroy( $chapterId )
    {
        // Remove the chapter
        Chapter::destroy( $chapterId );

        // Update any records that were assigned to that chapter

        $chapters = Chapter::where( 'assigned_to', '=', $chapterId )->get();

        foreach ( $chapters as $chapter ) {
            $chapter->assigned_to = '';
            $chapter->save();
        }

        return Response::json( [ 'status' => 'success' ] );
    }
}
