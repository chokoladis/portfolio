<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Example_work_stats;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class Example_work extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use Searchable;

    protected $table = 'example_works';
    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    public static $searchable = [
        'title',
        'description',
        'url_work'
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

        if (!$works = Cache::get($key)){
            
            $works = $query->paginate($arKeyCache['perPage'])->appends(request()->query());

            Cache::put($key,$works, 21600 ); // 6hours
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

    public static function boot() {

        parent::boot();

        static::creating(function($item) {

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
    
                        $filePath = public_path(config('filesystems.img.works').$filePath);
        
                        if (file_exists($filePath)){
                            unlink($filePath);
                        }

                        $folder = public_path(config('filesystems.img.works').$arPath[0]);
                        $countFiles = count(Storage::files($folder));
    
                        if (!$countFiles &&
                            $folder != public_path(config('filesystems.img.works'))) 
                            rmdir($folder);
                    }
                }
            }

        });
    }
}
