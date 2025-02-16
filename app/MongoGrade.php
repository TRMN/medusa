<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class MongoGrade extends Eloquent
{
    /**
     * @var array Fields that can be set
     */
    protected $fillable = ['grade', 'rank'];

    public static $gradeFilters = [
        'E' => 'Enlisted',
        'W' => 'Warrant Officer',
        'O' => 'Officer',
        'F' => 'Flag Officer',
        'C' => 'Civilian',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grades';
}