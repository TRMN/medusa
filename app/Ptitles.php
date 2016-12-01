<?php
use Jenssegers\Mongodb\Model as Eloquent;

class Ptitles extends Eloquent
{
    protected $fillable = ['title', 'code', 'precedence'];

    protected $table = 'ptitles';
}
