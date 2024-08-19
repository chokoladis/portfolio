<?php

namespace App\Services;

use Exception;
use \Imagick;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FileService
{
    const ACCEPT_FILE_SIZE = 15728640; // bites
    const LIMIT_FILES = 5;

    private UploadedFile $file;

    public $errors, $arSaved = [];
    public $request;
    public string $propertyName;
    public string $currentDir;
    static public $allowExt = [
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

                foreach ($files as $file) {

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

            if (!file_exists($root . $file_path)) {
                $this->file->move($root . $fileAr['subdir'], $fileAr['file_name']);
            }

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
        $ext = $this->file->getClientOriginalExtension();

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
            $salt = auth()->user()->id . '_' . time();

            $mime = $this->file->getMimeType();
            $arMime = explode('/', $mime);

            if ($arMime[0] === 'video'){
                $this->compressVideo($this->file);
            } elseif($arMime[0] === 'image'){
                $this->compressImage($this->file);
            }

            $file_name = md5($salt . '_' . $this->file->getClientOriginalName());
            $file_name = mb_substr($file_name, 0, 16) . '.' . $this->file->extension();

            $mk_name = substr($file_name, 0, 3);

            $folder = public_path() . '/'. $this->currentDir .'/' . $mk_name;
            if (!is_dir($folder)) {
                mkdir($folder, 755);
            }

            return ['subdir' => $mk_name, 'file_name' => $file_name];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function compressImage(UploadedFile $file){

        // $r = new \Imagick();
        
        
        // dd($r);
    }

    public static function compressVideo(UploadedFile $file){

    }

    public function addError(string $error)
    {

        $this->errors[] = $error;

        return true;
    }
}
