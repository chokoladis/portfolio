<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['deleted_at'];

    public function stats()
    {
        return $this->hasOne(Feedback_stats::class, 'feedback_id', 'id');
    }


    public static function boot() {

        parent::boot();

        static::creating(function($item) {

            Feedback_stats::query()
                ->create(['feedack_id' => $item->id]);

        });
    }
}
