<?php

class Chapter extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [ 'title', 'crest', 'co' ];

    public function members() {
        return $this->belongsToMany( 'User' );
    }

    public function co() {
        return $this->hasOne( 'User' );
    }

    public static function createChapter( $type, array $chapterAttributes, array $typeAttributes )
    {
        if( class_exists( $type ) )
        {
            $chapterType = $type::create( $typeAttributes );
            $chapterType->chapter()->create( $chapterAttributes );

            return $chapterType;
        } 
        else
        {
            throw new Exception( "Invalid chapter type" );
        } 
    } 

    public function chapterable() {
        return $this->morphTo();
    }
}