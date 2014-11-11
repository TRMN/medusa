<?php

class Report extends \Moloquent {
	protected $fillable = [];

    public function chapter()
    {
        return $this->belongsTo('Chapter', 'local_key', '_id');
    }
}
