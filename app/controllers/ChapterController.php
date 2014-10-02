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
        $chapters = Chapter::orderBy('chapter_type')->orderBy('chapter_name')->get();

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

        $includes = Chapter::where('assigned_to', '=', $detail->_id)->get();

        return View::make( 'chapter.show', [ 'detail' => $detail, 'higher' => $higher, 'includes' => $includes]);
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

        $chapters = Chapter::orderBy('chapter_type')->orderBy('chapter_name')->get(array('_id', 'chapter_name'));

        $chapterList[''] = "N/A";

        foreach($chapters as $chapter) {
            $chapterList[$chapter->_id] = $chapter->chapter_name;
        }

        return View::make( 'chapter.create', [ 'chapterTypes' => $chapterTypes, 'chapter' => new Chapter, 'chapterList' => $chapterList] );
    }

    /**
     * Save a newly created chapter
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();

        foreach($data as $k => $v) {
            if(empty($data[$k]) === true) {
                unset($data[$k]);
            }
        }

        Chapter::create( $data );

        return Redirect::route( 'chapter.index' );
    }

} 
