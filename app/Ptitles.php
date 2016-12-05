<?php
use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class Ptitles extends Model
{
    protected $fillable = ['title', 'code', 'precedence'];

    protected $table = 'ptitles';
}
