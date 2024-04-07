<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['deleted_at'];

    public function stats()
    {
        return $this->hasOne(Feedback_stats::class, 'feedback_id', 'id');
    }


    public static function boot() {

        parent::boot();

        static::created(function($item) {

            Feedback_stats::query()
                ->create(['feedback_id' => $item->id]);

        });
    }
}
