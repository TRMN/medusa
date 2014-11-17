<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Chapter extends Eloquent
{

    protected $fillable = [ 'chapter_name', 'chapter_type', 'hull_number', 'assigned_to', 'ship_class' ];

    public static $rules = [
        'chapter_name' => 'required|min:6|unique:chapters',
        'chapter_type' => 'required',
        'hull_number' => 'unique:chapters|required_if:chapter_type,ship'
    ];

    public static $updateRules = [
        'chapter_name' => 'required|min:6',
        'chapter_type' => 'required'
    ];

    public function report() {
        return $this->hasMany( 'Report' );
    }

    static function getChapters()
    {
        $results = Chapter::all();
        $chapters = [ ];

        foreach ( $results as $chapter ) {
            $chapters[ $chapter->_id ] = $chapter->chapter_name;

            if ( isset( $chapter->hull_number ) === true && empty( $chapter->hull_number ) === false ) {
                $chapters[ $chapter->_id ] .= ' (' . $chapter->hull_number . ')';
            }
        }

        asort( $chapters, SORT_NATURAL );

        $chapters = [ '' => "Select a Chapter" ] + $chapters;

        return $chapters;
    }

    public function getCrew() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->whereNotIn( 'assignment.billet', [ 'CO', 'XO', 'Bosun' ])->get();

        return $users;
    }

    public function getCO() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->where( 'assignment.billet', '=', 'CO' )->get();
        return $users;
    }

    public function getXO() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->where( 'assignment.billet', '=', 'XO' )->get();

        return $users;
    }

    public function getBosun() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->where( 'assignment.billet', '=', 'Bosun' )->get();

        return $users;
    }

    public function reports()
    {
        return $this->hasMany('Report', 'foreign_key', 'ship_information.chapter_id');
    }

}
