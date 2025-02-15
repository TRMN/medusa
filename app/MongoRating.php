<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class MongoRating extends Eloquent
{
    protected $fillable = ['rate_code', 'rate'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ratings';
}