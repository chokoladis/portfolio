<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Http\Controllers\WorkersController;

class Workers extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function boot() {

        parent::boot();

        self::updating(function($model){
            
            dd($model);

            $old_avatar = $model->url_avatar;

            if ($old_avatar && file_exists(public_path() . $old_avatar)){
                unlink(public_path() . $old_avatar);
            }
        });
        
        
        static::deleted(function($item) {            

            if ($item->url_avatar){
    
                $filePath = $item->url_avatar;

                $arPath = explode('/', $filePath);

                $filePath = public_path(WorkersController::$folderImg.$filePath);

                if (file_exists($filePath)){
                    unlink($filePath);
                }

                $folder = public_path(WorkersController::$folderImg.$arPath[0]);
                $countFiles = count(Storage::files($folder));

                if (!$countFiles) rmdir($folder);
            }
            // Log::info('Deleted event call: '.$item); 

        });

    }
}
