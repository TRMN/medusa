<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumUser extends Model
{
    protected $fillable = ['user_email'];

    protected $connection = 'mysql';

    protected $table = 'phpbb_users';

    protected $primaryKey = 'user_id';

    public $timestamps = false;
}
