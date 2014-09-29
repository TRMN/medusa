<?php
/**
 * Created by PhpStorm.
 * User: dweiner
 * Date: 9/27/14
 * Time: 10:08 PM
 */

class ChapterController extends BaseController {

    public function index()
    {
        $chapters = Chapter::all();

        for ($i = 0; $i < count($chapters); $i++) {
            $chapters[$i]->chapter_type = ucfirst($chapters[$i]->chapter_type);
        }

        return View::make( 'chapter.index', [ 'chapters' => $chapters ] );
    }

    public function show($chapterID)
    {
        $detail = Chapter::find($chapterID);

        $detail->chapter_type = ucfirst($detail->chapter_type);

        if (isset($detail->assigned_to)) {
            $higher = Chapter::find($detail->assigned_to);
        } else {
            $higher = false;
        }

        return View::make( 'chapter.show', [ 'detail' => $detail, 'higher' => $higher]);
    }

    /**
     * Show the form for creating a new chapter
     *
     * @return Response
     */
    public function create()
    {
        $types = Type::all();
        $chapterTypes = array();

        foreach($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] = $chapterType->chapter_description;
        }

        return View::make( 'chapter.create', [ 'chapterTypes' => $chapterTypes] );
    }

    /**
     * Save a newly created chapter
     *
     * @return Response
     */
    public function save()
    {
        $data = Input::all();

        die("<pre>" . print_r($data, true));
//        Chapter::create( $data );
//
//        return Redirect::route( 'chapter.index' );
    }

} 
