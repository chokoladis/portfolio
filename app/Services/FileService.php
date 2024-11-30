<?php

namespace App\Services;

use App\Models\Files;
use App\Models\Optimizer;
use App\Traits\Errors;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FileService
{
    use Errors;

    const ACCEPT_FILE_SIZE = 15728640; // bytes
    const ACCEPT_FILE_SIZE_MB = self::ACCEPT_FILE_SIZE / 1048576;
    const LIMIT_FILES = 5;
    const DEFAULT_IMG_PATH = '';

    private UploadedFile $file;

    public array $errors, $arFilesId, $validationData;
    public string $propertyName;
    public string $currentDir;
    public string $entity;
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


    function __construct(array $data, string $propertyName, string $entity)
    {
        $this->errors = [];
        $this->arFilesId = [];
        $this->validationData = $data;
        $this->propertyName = $propertyName;
        $this->entity = $entity;
        $this->currentDir = config('filesystems.clients.'.$entity);
    }

    public function handlerFiles()
    {
        try {

            if (isset($this->validationData[$this->propertyName])){

                $files = $this->validationData[$this->propertyName];

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
                $this->errors[] = $this->compileError('files_not_find', 'Файлы не найдены');
            }

            return [$this->arFilesId, $this->errors];
        } catch (\Exception $e){
            return [false, [$e->getMessage()]];
        }
    }

    public function saveFile()
    {
        try {
            $root = public_path() . $this->currentDir;

            $fileAr = self::preparationSave();

            if (!empty($fileAr['error'])) {
                $this->errors[] = $fileAr['error'];
                return false;
            }

            $file_path = $fileAr['subdir'] . '/' . $fileAr['file_name'];

            $newFile = Files::create([
                'name' => $fileAr['file_name'],
                'path' => $file_path,
                'entity_code' => $this->entity,
            ]);

            $this->arFilesId[] = $newFile->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function isHaveErrors()
    {
        $ext = strtolower($this->file->getClientOriginalExtension());

        // todo test
        if (!in_array($ext, self::$allowExt)) {
            $this->addError(['not_support', 'Файл - ' . $this->file->getClientOriginalName() . ' имеет не поддерживаемое расширение']);
        }

        if ($this->file->getSize() > self::ACCEPT_FILE_SIZE) {
            $this->addError(['big_size', 'Файл - ' . $this->file->getClientOriginalName() . ' имеет слишком большой размер']);
        }

        if (!$this->file->isValid()) {
            $this->addError(['have_errors', 'Файл - ' . $this->file->getClientOriginalName() . ' имеет ошибки']);
        }

        return !empty($this->errors);
    }

    public function preparationSave()
    {

        try {
            $root = public_path() . $this->currentDir;
            $ext = strtolower($this->file->getClientOriginalExtension());

            $salt = auth()->user()->id . '_' . time();

            $file_name = md5($salt . '_' . $this->file->getClientOriginalName());
            $subdir = substr($file_name, 0, 3);

            if (!is_dir($root . 'temp/')) {
                mkdir($root . 'temp/', 0755, true);
            }

            $this->file->move($root . 'temp/' . $subdir, $file_name . '.' . $ext);

            return ['subdir' => 'temp/' . $subdir, 'file_name' => $file_name.'.' . $ext];
        } catch (\Throwable $th) {
            Log::error($th, ['function' => 'preparationSave']);
            return ['error' => $this->compileError($th->getCode(), $th->getMessage())];
        }
    }

    public static function compressImage(string $fullTempPath, string $folder_path, string $file_name)
    {

        $file_name = mb_substr($file_name, 0, 16) . '.webp';
        $fullPath = $folder_path . $file_name;

        try {
            $out = [];
            // $exec = exec('magick '.$fullTempPath.' -quality 80% '.$fullPath); //old
            $exec = exec('convert ' . $fullTempPath . ' -quality 80% ' . $fullPath); //hosting

            // Log::debug('img 2 - '. $fullPath);
            // Log::debug('exec', [$exec]);
            // Log::debug('out', [$out]);

            unlink($fullTempPath);

            return $file_name;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public static function compressVideo(string $fullTempPath, string $folder_path, string $file_name, string $ext)
    {

        $file_name = mb_substr($file_name, 0, 16) . '.' . $ext;
        $fullPath = $folder_path . $file_name;

        try {
            $exec = exec('ffmpeg -i ' . $fullTempPath . ' -b:v 800k ' . $fullPath); //hosting
            // $exec = exec('ffmpeg -i ' . $fullTempPath . ' -b 800k ' . $fullPath); //old

            // unlink($fullTempPath);

            return $file_name;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function addError(array $error)
    {
        $this->errors[] = $this->compileErrorFromArray($error);
    }

    public static function getById(int $id)
    {
        return Cache::remember('id_' . $id, 3600000, function () use ($id) {
            return Files::query()->find($id)->first();
        });
    }
}
