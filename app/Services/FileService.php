<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileService
{
    const ACCEPT_FILE_SIZE = 15728640; // bytes
    const ACCEPT_FILE_SIZE_MB = self::ACCEPT_FILE_SIZE / 1048576;
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

                    if ($i + 1 > self::LIMIT_FILES) {
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

        if ($this->file->getSize() > self::ACCEPT_FILE_SIZE) {
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
            $ext = strtolower($this->file->getClientOriginalExtension());

            $salt = auth()->user()->id . '_' . time();

            $mime = $this->file->getMimeType();
            $arMime = explode('/', $mime);

            $file_name = md5($salt . '_' . $this->file->getClientOriginalName());
            $subdir = substr($file_name, 0, 3);

            $fullTempPath = $root . 'temp/' . $subdir . '/' . $file_name . '.' . $ext;

            if (!is_dir($root . 'temp/')) {
                mkdir($root . 'temp/', 0755);
            }

            $this->file->move($root . 'temp/' . $subdir, $file_name . '.' . $ext);
            $size = filesize($root . 'temp/' . $subdir .'/' . $file_name . '.' . $ext);

            $folder = $root  . $subdir . '/';

            if (!is_dir($folder)) {
                mkdir($folder, 0755);
            }


            if ($arMime[0] === 'video' && $size > 700000) { // 700kb

                $compress = $this->compressVideo($fullTempPath, $folder, $file_name, $this->file);

                $file_name = $compress ? $compress :  mb_substr($file_name, 0, 16) . '.' . $ext;

            } elseif (
                $arMime[0] === 'image' && $ext !== 'webp'
                || ($ext === 'webp' && $size > 300000)
            ) {

                $compress = $this->compressImage($fullTempPath, $folder, $file_name, $this->file);

                $file_name = $compress ? $compress :  mb_substr($file_name, 0, 16) . '.' . $ext;

            } else {

                copy($root . 'temp/' . $subdir .'/' . $file_name.'.'.$ext, $root . $subdir . '/' . mb_substr($file_name, 0, 16) . '.' . $ext);

                $file_name = mb_substr($file_name, 0, 16) . '.' . $ext;
            }

            return ['subdir' => $subdir, 'file_name' => $file_name];
        } catch (\Throwable $th) {
            Log::error($th, ['function' => 'preparationSave']);
            return redirect()->back()->with('error', 'Error handler files');
        }
    }

    public static function compressImage(string $fullTempPath, string $folder_path, string $file_name, UploadedFile $file)
    {

        $file_name = mb_substr($file_name, 0, 16) . '.webp';
        $fullPath = $folder_path . $file_name;

        try {
            // $exec = exec('magick '.$fullTempPath.' -quality 80% '.$fullPath); //old
            $exec = exec('convert ' . $fullTempPath . ' -quality 80% ' . $fullPath); //hosting

            unlink($fullTempPath);

            return $file_name;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public static function compressVideo(string $fullTempPath, string $folder_path, string $file_name, UploadedFile $file)
    {

        $file_name = mb_substr($file_name, 0, 16) . '.' . $file->getClientOriginalExtension();
        $fullPath = $folder_path . $file_name;

        try {
            $exec = exec('ffmpeg -i ' . $fullTempPath . ' -b:v 800k ' . $fullPath);
            
            unlink($fullTempPath);

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
