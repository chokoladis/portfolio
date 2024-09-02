<?php

namespace App\Http\Controllers;

use App\Models\Optimizer;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OptimizerController extends Controller
{
    public $timeOptimize = 600;
    
    static function optimize(){

        $process_id = time();
        $needOptimize = false;

        $inProccess = Optimizer::query()
            ->whereNotNull('start_generate_at')
            ->where('is_optimize', 0)
            ->orderBy('id', 'DESC')
            ->first();

        Log::debug('1', ['inProccess' => $inProccess]);

        if ($inProccess){

            if (($process_id - intval($inProccess->start_generate_at)) > self::$timeOptimize){
                $model = $inProccess;
                $needOptimize = true;
            } else {
                return responseJson(false, error: [
                    'message' => 'now in proccess',
                    'model' => ['id' => $inProccess->id, 'path' => $inProccess->path]
                ]);
            }
        } else {
            $notOptimizing = Optimizer::query()
                ->whereNull('start_generate_at')
                ->where('is_optimize', 0)
                ->orderBy('id', 'DESC')
                ->first();

            Log::debug('2', ['notOptimizing' => $notOptimizing]);

            if (!is_null($notOptimizing)){
                $model = $notOptimizing;
                $needOptimize = true;
            }
        }

        return $needOptimize ? self::start($model) : 'not need optimize';
    }

    static function start(Model $model){

        $mainDir = config('filesystems.clients.'.$model->model_name);
        Log::debug('maindir', [$mainDir]);
        $root = public_path() . $mainDir;
        
        $fullTempPath = $root . $model->path;

        $size = filesize($fullTempPath);

        $arFilePath = explode('/', $model->path);

        if ($arFilePath[0] === 'temp'){
            unset($arFilePath[0]); // temp
            $subdir = $arFilePath[1];
            $file_name = $arFilePath[2];    
        } else {
            $subdir = $arFilePath[0];
            $file_name = $arFilePath[1];
        }
        
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $mime = mime_content_type($fullTempPath);
        $arMime = explode('/', $mime);

        $newFileName = mb_substr($file_name, 0, 16) . '_opt.' . $ext;
        $newPath = $root . $subdir .'/' . $newFileName;
        $newFolderPath = $root  . $subdir . '/';

        if (!is_dir($newFolderPath)) {
            mkdir($newFolderPath, 0755);
        }

        if ($arMime[0] === 'video' && $size > 700000) { // 700kb

            $compress = FileService::compressVideo($fullTempPath, $newFolderPath, $file_name, $ext);

            $file_name = $compress ? $compress :  $newFileName;

        } elseif (
            $arMime[0] === 'image' && $ext !== 'webp'
            || ($ext === 'webp' && $size > 300000)
        ) {

            $compress = FileService::compressImage($fullTempPath, $newFolderPath, $file_name);

            $file_name = $compress ? $compress :  $newFileName;

        } else {

            copy($root . $model->path, $newPath);

            $file_name = $newFileName;
        }

        $newFilePath = $subdir .'/' . $file_name;

        if ($model->update([ 'is_optimize' => 1,  'process_id' => null ])){

            self::beforeUpdateOptimizer($model, $newFilePath);

            return responseJson(response:[
                'message' => 'success optimizing',
                'model' => ['id' => $model->id, 'process_id' => $model->process_id]
            ]);    
        } else {
            return responseJson(false, error:[
                'message' => 'error saving',
                'model' => ['id' => $model->id, 'process_id' => $model->process_id]
            ]);
        }
    }

    static function beforeCreateModel(Model $model, string $entity, string $propName){

        $arFiles = explode(',', $model->$propName);

        foreach($arFiles as $path){
            
            Optimizer::create([
                'path' => $path,
                'model_name' => $entity,
                'model_id' => $model->id,
            ]);

        }

    }

    static function beforeUpdateOptimizer(Model $item, string $newPath){

        try {
            $m_name = $item->model_name;
            $newFullpath = '';

            $modelClass = 'App\Models\\'.$m_name;
            
            $model = $modelClass::query()
                ->where('id', $item->model_id)
                ->first();
            
            if ($model){

                $propName = config('filesystems.property.'.$m_name);

                $arFilesPath = explode(',', $model->$propName);
                $last = last($arFilesPath);
                foreach ($arFilesPath as $path) {

                    $c = $path === $last ? '' : ', ';
                    $path = trim($path);
                    
                    $path = $path === $item->path ? $newPath : $path;

                    $newFullpath .= $path.$c;
                }

                $model->update([$propName => $newFullpath]);
            }
        } catch (\Throwable $th) {
            log::error($th);
        }
    }
}
