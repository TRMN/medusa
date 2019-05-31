<?php


namespace App\Medusa\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = ['member_id', 'action', 'collection_name', 'document_id', 'document_values', 'from_where'];

    protected $table = 'audit_trail';
}