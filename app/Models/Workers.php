<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Example_work;
use Illuminate\Support\Facades\Log;

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

    static $columnsInputs = [
        'phone' => 'Телефон', 
        'about' => 'О себе',
        'socials' => 'Соц.ссылки',
    ];

    public function getRouteKeyName(){
        return 'code';
    }

    public static function getRouteAddress(){
        return 'workers.detail';
    }
    
    public function getTitle(){
        return $this->user->fio;
    }

    public function getColumns(){

        $tableName = $this->getTable();

        $columns = Schema::getColumnListing($tableName);

        foreach($columns as $col){
            
            if (isset(self::$columnsInputs[$col])){
                $translate = trans('crud.Workers.fields.'.$col);
                if ($translate){
                    $res[$col]['name_ru'] = $translate;
                    $res[$col]['type'] = Schema::getColumnType($tableName, $col);
                }
            }
        }

        return $res;
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

    public function stats()
    {
        return $this->hasOne(Workers_stats::class, 'worker_id', 'id');
    }
    
    public static function boot() {

        parent::boot();

        static::created(function($item) {

            Workers_stats::query()
                ->create(['worker_id' => $item->id]);

        });

        self::updating(function($model){

            $old_avatar = $model->getOriginal('url_avatar');            
            $new_avatar = $model->url_avatar;

            if ($new_avatar && $new_avatar != $old_avatar && $old_avatar){

                $real_path = public_path().config('filesystems.clients.Workers'). $old_avatar;
                
                if (file_exists($real_path)){
                    unlink($real_path);
                }

                $arPath = explode('/', $old_avatar);
                $folder = public_path(config('filesystems.clients.Workers').$arPath[0]);
                if (is_dir($folder)){
                    $countFiles = count(Storage::files($folder));

                    if (!$countFiles) rmdir($folder);
                }
            }
        });
        
        
        static::deleted(function($item) {            

            if ($item->url_avatar){
    
                $filePath = $item->url_avatar;

                $arPath = explode('/', $filePath);

                $filePath = public_path(config('filesystems.clients.Workers').$filePath);

                if (file_exists($filePath)){
                    unlink($filePath);
                }

                $folder = public_path(config('filesystems.clients.Workers').$arPath[0]);
                if (is_dir($folder)){
                    $countFiles = count(Storage::files($folder));

                    if (!$countFiles) rmdir($folder);
                }
            }
            // Log::info('Deleted event call: '.$item); 

        });

    }
}
