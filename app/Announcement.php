<?php

use Jenssegers\Mongodb\Model as Eloquent;

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
        return $this->belongsTo('User');
    }

    public function getPublishLabels()
    {
        return [  0  => 'Unpublished' , 1 => 'Publish' , ];
    }
}
