<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Announcement extends Eloquent
{

    public $fillable = [
        'user_id',
        'summary',
        'body',
        'is_published',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function getPublishLabels()
    {
        return [  0  => 'Unpublished' , 1 => 'Publish' , ];
    }
}
