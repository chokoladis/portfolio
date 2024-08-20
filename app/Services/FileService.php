<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileService
{
    const ACCEPT_FILE_SIZE = 15728640; // bites
    const LIMIT_FILES = 5;

    private UploadedFile $file;

    public $errors, $arSaved = [];
    public $request;
    public string $propertyName;
    public string $currentDir;
    static $imgExt = [
        'png',
        'webp',
        'jpeg',
        'jpg',
        'gif',
    ];
    static $videoExt = [
        'mp4',
        'avi',
        'mov',
        'webm',
        'mkv',
        'wmv',
        'amv',
        'm4v',
        '3gp',
        'mpeg-4',
    ];
    static $allowExt = [
        'png',
        'webp',
        'jpeg',
        'jpg',
        'gif',
        'mp4',
        'avi',
        'mov',
        'webm',
        'mkv',
        'wmv',
        'amv',
        'm4v',
        '3gp',
        'mpeg-4',
        'docx',
        'xlsx',
        'pdf',
        'txt',
        'zip',
        'rar',
        'tar'
    ];


    function __construct($request, string $propertyName, string $currentDir)
    {
        if (!$request instanceof Request) {
            throw new Exception("Param Request if not instanceof Request", 400);
        }

        $this->request = $request;
        $this->propertyName = $propertyName;
        $this->currentDir = $currentDir;
        // $this->errors = [];
        // $this->arSaved = [];
    }

    // function __destruct()
    // {
    //     $this->errors = [];
    //     $this->arSaved = [];
    // }

    public function handlerFiles()
    {

        if ($this->request->hasFile($this->propertyName)) {

            $files = $this->request->file($this->propertyName);

            if (is_array($files)) {

                foreach ($files as $i => $file) {

                    if ($i + 1 > self::LIMIT_FILES){
                        break;
                    }

                    $this->file = $file;

                    if (!$this->isHaveErrors()) {
                        $this->saveFile();
                    }
                }
            } else {

                $this->file = $files;

                if (!$this->isHaveErrors()) {
                    $this->saveFile();
                }
            }
        } else {
            $this->errors = ['Файлы не найдены'];
        }

        return ['file_saved' => $this->arSaved, 'errors' => $this->errors];
    }

    public function saveFile()
    {
        try {
            $root = public_path() . $this->currentDir;

            $fileAr = self::preparationSave($this->file);

            $file_path = $fileAr['subdir'] . '/' . $fileAr['file_name'];

            // if (!file_exists($root . $file_path)) {
            //     $this->file->move($root . $fileAr['subdir'], $fileAr['file_name']);
            // }

            $this->arSaved[] = [
                'originalName' => $this->file->getClientOriginalName(),
                'newName' => $fileAr['file_name'],
                'path' => $file_path
            ];

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function isHaveErrors()
    {
        $ext = strtolower($this->file->getClientOriginalExtension());

        if (!in_array($ext, self::$allowExt)) {
            return $this->addError('Файл - ' . $this->file->getClientOriginalName() . ' имеет не поддерживаемое расширение');
        }

        if ($this->file->getSize() > self::ACCEPT_FILE_SIZE){
            return $this->addError('Файл - ' . $this->file->getClientOriginalName() . ' имеет слишком большой размер');
        }

        if (!$this->file->isValid()) {
            return $this->addError('Файл - ' . $this->file->getClientOriginalName() . ' имеет ошибки');
        }

        return false;
    }

    public function preparationSave(): array
    {

        try {
            $root = public_path() . $this->currentDir;

            $salt = auth()->user()->id . '_' . time();

            $mime = $this->file->getMimeType();
            $arMime = explode('/', $mime);

            $file_name = md5($salt . '_' . $this->file->getClientOriginalName());

            $subdir = substr($file_name, 0, 3);

            // temp check
            $tempPath = 'temp/'.$subdir. $file_name. '.' .$this->file->getClientOriginalExtension();

            $tempStore = $this->file->move($root.'temp/'.$subdir, $file_name. '.' .$this->file->getClientOriginalExtension());

            Log::alert($tempStore);

            $folder = public_path() . $this->currentDir  . $subdir;

            if (!is_dir($folder)) {
                mkdir($folder, 0755);
            }

            if ($arMime[0] === 'video'){

                $file_name = $this->compressVideo($tempPath, $this->currentDir, $folder, $file_name, $this->file)
                    ?? mb_substr($file_name, 0, 16) . '.' . $this->file->getClientOriginalExtension();

            } elseif($arMime[0] === 'image'){

                $file_name = $this->compressImage($tempPath, $this->currentDir, $folder, $file_name, $this->file)
                    ?? mb_substr($file_name, 0, 16) . '.' . $this->file->getClientOriginalExtension();

            } else {
                $file_name = mb_substr($file_name, 0, 16) . '.' . $this->file->getClientOriginalExtension();
            }

            return ['subdir' => $subdir, 'file_name' => $file_name];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function compressImage(string $tempPath, string $currDir, string $folder_path, string $file_name, UploadedFile $file){

        $root = public_path() . $currDir;

        $file_name = mb_substr($file_name, 0, 16) . '.webp';
        $fullPath = $folder_path.$file_name;

        dump($tempPath);
        dump($file);
        // dump($file->getRealPath());

        try{
            $exec = exec('magick '.$root. $tempPath.' -quality 20 '.$root. $fullPath);

            Log::error($exec);

            return $file_name;

        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public static function compressVideo(string $tempPath, string $currDir, string $folder_path, string $file_name, UploadedFile $file){

        $root = public_path() . $currDir;

        $file_name = mb_substr($file_name, 0, 16) . '.' . $file->getClientOriginalExtension();
        $fullPath = $folder_path.$file_name;
        
        dump($tempPath);
        dump($root. $tempPath);
        dump($fullPath);
        // dump($file->getRealPath());

        try {
            $exec = exec("ffmpeg -i ".$root. $tempPath." -b:v 400 $fullPath");
            
            Log::error($exec);

            return $file_name;

        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function addError(string $error)
    {

        $this->errors[] = $error;

        return true;
    }
}
