<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optimizer extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::updating(function ($item) {
            
    //         $model = $$item->model_name::query()
    //             ->where('id', $item->model_id)
    //             ->first();
            
    //         $arFilesPath = explode(',', $model->path);
    //         foreach ($arFilesPath as $path) {
    //             $path = trim($path);
                
    //             if ($path === $item->path){

    //             }
                
    //         }
    //     });
    // }

}
