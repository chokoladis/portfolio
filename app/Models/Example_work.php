<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Example_work extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'example_works';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function boot() {

        parent::boot();

        // static::updating(function($item) {            

        //     Log::info('Updating event call: '.$item);   

        //     $item->slug = Str::slug($item->name);

        // });

        static::deleted(function($item) {            

            Log::info('Deleted event call: '.$item); 

        });

    }
}
