<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Example_work_stats;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Example_work extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'example_works';
    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    public static $searchable = [
        'title',
        'description',
        'url_work'
    ];

    static $columnsInputs = [
        'title' => 'Заголовок',
        'description' => 'Описание', 
        'url_work' => 'Ссылка на результат',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string', 
        'slug' => 'string',
        'url_files' => 'string',
        'url_work' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
    
    const DEFAULT_PAGE = 1;
    const DEFAULT_PERPAGE = 5;

    public function getTitle(){
        return $this->title;
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public static function getRouteAddress(){
        return 'work.detail';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function stats()
    {
        return $this->hasOne(Example_work_stats::class, 'work_id', 'id');
    }

    public static function getCacheList($arKeyCache, $query){

        $key = implode(',', $arKeyCache);
        $key = str_replace(',', '_', $key);

        $request = array_diff_key(request()->all(), $arKeyCache);

        if (empty($request)){
            if (!$works = Cache::get($key)){

                $works = $query->paginate($arKeyCache['per_page'])->appends(request()->query());
    
                Cache::put($key,$works, 21600 ); // 6hours
            }
        } else {
            $works = $query->paginate($arKeyCache['per_page'])->appends(request()->query());
        }

        return $works;
    }

    public static function getCacheOne($id){
        
        $key = static::class.'_'.$id;

        if (!$work = Cache::get($key)){
            
            $work = Example_work::find($id);

            Cache::put($key,$work, 21600 ); // 6hours
        }

        return $work;
    }

    public function getColumns(){

        $tableName = $this->getTable();

        $columns = Schema::getColumnListing($tableName);

        foreach($columns as $col){
            
            if (isset(self::$columnsInputs[$col])){
                $translate = trans('crud.Example_work.fields.'.$col);
                if ($translate){
                    $res[$col]['name_ru'] = $translate;
                    $res[$col]['type'] = Schema::getColumnType($tableName, $col);
                }
            }
        }

        return $res;
    }

    public static function boot() {

        parent::boot();

        static::created(function($item) {

            Example_work_stats::query()
                ->create(['work_id' => $item->id]);

        });

        static::updating(function($item) {            
            Cache::delete(static::class.'_'.$item->id);
            Cache::delete(static::class.'_'.self::DEFAULT_PAGE.'_'.self::DEFAULT_PERPAGE);
        });

        static::deleting(function($item) {

            if ($item->deleted_at){ // удаляется жестко

                if ($item->url_files){

                    $arUrlFiles = explode(',', $item->url_files);
        
                    foreach($arUrlFiles as $filePath){

                        $filePath = trim($filePath);
                        $arPath = explode('/', $filePath);
    
                        $filePath = public_path(config('filesystems.clients.works').$filePath);
        
                        if (file_exists($filePath)){
                            unlink($filePath);
                        }

                        $folder = public_path(config('filesystems.clients.works').$arPath[0]);
                        $countFiles = count(Storage::files($folder));
    
                        if (!$countFiles &&
                            $folder != public_path(config('filesystems.clients.works'))) 
                            rmdir($folder);
                    }
                }
            }

        });
    }
}
