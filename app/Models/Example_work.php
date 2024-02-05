<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Http\Controllers\ExampleWorkController;
use Carbon\Carbon;
use PharIo\Manifest\Url;

class Example_work extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'example_works';
    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    protected $casts = [
        'title' => 'string',
        'description' => 'string', 
        'slug' => 'string',
        'url_files' => 'string',
        'url_work' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

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

            if ($item->url_files){

                $arUrlFiles = explode(',', $item->url_files);
    
                foreach($arUrlFiles as $filePath){
                    
                    $filePath = trim($filePath);
                    $arPath = explode('/', $filePath);

                    $filePath = public_path(ExampleWorkController::$folderImg.$filePath);
    
                    if (file_exists($filePath)){
                        unlink($filePath);
                    }

                    $folder = public_path(ExampleWorkController::$folderImg.$arPath[0]);
                    $countFiles = count(Storage::files($folder));

                    if (!$countFiles &&
                        $folder != public_path(ExampleWorkController::$folderImg)) 
                        rmdir($folder);
                }
            }

        });

    }
}
