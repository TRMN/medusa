<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Announcement extends Eloquent {

    public $fillable = [
        'user_id',
        'summary',
        'body',
        'is_published',
    ];

    public function user()
    {
        return $this->belongsTo( 'User' );
    }

}
