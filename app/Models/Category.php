<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $tableFields = [ 'id', 'name', 'active', 'entity_code', 'updated_at', 'preview_src' ];
}
