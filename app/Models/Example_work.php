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
use Illuminate\Support\Facades\Schema;
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


    static $columnsEdit = [
        'title' => 'Заголовок',
        'description' => 'Описание', 
        // 'url_files' => 'Ссылки на картинки/скриншоты',
        'url_work' => 'Ссылка на результат',
    ];
    
    public function getColumns(){

        $tableName = $this->getTable();
  
        $columns = Schema::getColumnListing($tableName);
        
        foreach($columns as $col){
            if ($col !== 'id'
                && array_key_exists($col,self::$columnsEdit)){
                $res[$col]['name_ru'] = self::$columnsEdit[$col];
                $res[$col]['type'] = Schema::getColumnType($tableName, $col);
            }
        }

        return $res;
    }

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
