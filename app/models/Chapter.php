<?php

class Chapter extends Moloquent {

    protected $fillable = [ 'chapter_name', 'chapter_type', 'hull_number', 'assigned_to', 'ship_class' ];

    static function getChapters()
    {
        $results = Chapter::all();
        $chapters = array();

        foreach ($results as $chapter) {
            $chapters[$chapter->_id] = $chapter->chapter_name;

            if (isset($chapter->hull_number) === true && empty($chapter->hull_number) === false) {
                $chapters[$chapter->_id] .= ' (' . $chapter->hull_number . ')';
            }
        }

        asort($chapters, SORT_NATURAL);

        $chapters = array('' => "Select a Chapter") + $chapters;

        return $chapters;
    }

} 
