<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Report extends Eloquent {

	protected $fillable = [];

    public function chapter()
    {
        return $this->belongsTo( 'Chapter', 'local_key', '_id' );
    }
}
