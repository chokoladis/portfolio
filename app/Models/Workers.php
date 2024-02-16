<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Example_work;
use App\Http\Controllers\WorkersController;

class Workers extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [];

    public static $searchable = [
        'code',
        'phone',
        'about'
    ];

    public function getRouteKeyName(){
        return 'code';
    }

    public static function getRouteAddress(){
        return 'workers.detail';
    }
    
    public function getTitle(){
        return $this->user->name;
    }

    public function getWorks(int $limit = 3)
    {
        return Example_work::query()
            ->where(['user_id' => $this->user->id])
            ->limit($limit)
            ->get();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function boot() {

        parent::boot();

        self::updating(function($model){

            $old_avatar = $model->getOriginal('url_avatar');
            $real_path = public_path().WorkersController::$folderImg. $old_avatar;

            if ($old_avatar && file_exists($real_path)){
                unlink($real_path);
            }

            $arPath = explode('/', $old_avatar);
            $folder = public_path(WorkersController::$folderImg.$arPath[0]);
            if (is_dir($folder)){
                $countFiles = count(Storage::files($folder));

                if (!$countFiles) rmdir($folder);
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
                if (is_dir($folder)){
                    $countFiles = count(Storage::files($folder));

                    if (!$countFiles) rmdir($folder);
                }
            }
            // Log::info('Deleted event call: '.$item); 

        });

    }
}
