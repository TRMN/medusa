<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
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
