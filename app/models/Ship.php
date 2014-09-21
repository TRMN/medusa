<?php

class Ship extends \Eloquent {
    protected $table = 'chapters_ships';

    public static $rules = [
        'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [ 'title', 'crest', 'co', 'xo', 'bosun' ];

    public function xo() {
        return $this->hasOne( 'User' );
    }

    public function bosun() {
        return $this->hasOne( 'User' );
    }

    public function chapter() {
        return $this->morphOne( 'Chapter', 'chapterable' );
    }
}