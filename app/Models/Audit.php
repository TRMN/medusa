<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Audit extends Eloquent
{
    protected $fillable = ['member_id', 'action', 'collection_name', 'document_id', 'document_values', 'from_where'];

    protected $table = 'audit_trail';
}
