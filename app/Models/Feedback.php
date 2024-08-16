<?php

namespace App\Models;

use App\Mail\FeedbackMail;
use App\Mail\testMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

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

            Mail::to(config('mail.default_email'))
                ->send(new FeedbackMail($item));

            Feedback_stats::query()
                ->create(['feedback_id' => $item->id]);

        });
    }
}
