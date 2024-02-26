<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example_work_stats extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getTable() {
        return 'example_works_stats';
    }
}
