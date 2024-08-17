<?

namespace App\Services;

use Exception;
use Illuminate\Http\Request;

class FileService{

    const ACCEPT_FILE_SIZE = 15728640;
    const ACCEPT_FILE_SIZE_MB = self::ACCEPT_FILE_SIZE/1048576;
    const LIMIT_FILES = 10;

    public $request;
    public string $propertyName;
    public string $currentDir;

    public function __construct($request, string $propertyName, string $currentDir)
    {
        // if (!$request instanceof Request){
        //     throw new Exception("Param Request if not instanceof Request", 400);
        // }
        dd($request);

        $this->request = $request;
        $this->propertyName = $propertyName;
        $this->currentDir = $currentDir;
    }

    public function handlerFiles(){

        $root = public_path() . $this->currentDir;        

        dd(1);
        if ($this->request->hasFile($this->propertyName)) {
            
            $files = $this->request->file($this->propertyName);

            if (is_array($files)){

                $file_path = '';

                foreach ($files as $file) {

                    $this->hanlderFile($file);
                    // if ($file->isValid()){
                    //     $fileAr = self::generatePhotoPath($file, $currentDir);
                    //     $file_path .= $fileAr['subdir'].'/'.$fileAr['file_name'].', ';

                    //     if (!file_exists($root.$file_path)){
                    //         $file->move($root.$fileAr['subdir'], $fileAr['file_name']);
                    //     }
                    // }
                }

                // $file_path = trim($file_path);
                // $file_path_len = mb_strlen($file_path);
                // $file_path = mb_substr($file_path, 0, $file_path_len - 1);

            } else {

                $this->hanlderFile($files);

                // $fileAr = self::generatePhotoPath($files, $currentDir);
                // $file_path = $fileAr['subdir'].'/'.$fileAr['file_name'];

                // if (!file_exists($root.$file_path)){
                //     $files->move($root.$fileAr['subdir'], $fileAr['file_name']);
                // }
            }
            
        } else {
            $file_path = '';
        }

        return $file_path;
    }

    public function hanlderFile($file){

        return self::getTypeFile($file);

    }

    static function getTypeFile($file){


        dd($file);

        // if ($file->isValid()){
        //     $fileAr = self::generatePhotoPath($file, $currentDir);
        //     $file_path .= $fileAr['subdir'].'/'.$fileAr['file_name'].', ';

        //     if (!file_exists($root.$file_path)){
        //         $file->move($root.$fileAr['subdir'], $fileAr['file_name']);
        //     }
        // }
    }

    static function compressImage(){

    }

    static function compressVideo(){

    }

}