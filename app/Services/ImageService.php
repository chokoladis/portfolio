<?php

namespace App\Services;

class ImageService {

    const ACCEPT_FILE_SIZE = 3150000;
    const ACCEPT_FILE_SIZE_MB = self::ACCEPT_FILE_SIZE/1048576;
    const LIMIT_FILES = 5;

    public static function getNewPhotoPath($request, $propName, $mainDir){
        
        $root = public_path() . $mainDir;

        if ($request->hasFile($propName)) {
            
            $photo = $request->file($propName);

            if (is_array($photo)){

                $file_path = '';

                foreach ($photo as $file) {

                    if ($file->isValid()){
                        $fileAr = self::generatePhotoPath($file, $mainDir);
                        $file_path .= $fileAr['subdir'].'/'.$fileAr['file_name'].', ';

                        if (!file_exists($root.$file_path)){
                            $file->move($root.$fileAr['subdir'], $fileAr['file_name']);
                        }
                    }
                }

                $file_path = trim($file_path);
                $file_path_len = mb_strlen($file_path);
                $file_path = mb_substr($file_path, 0, $file_path_len - 1);
            } else {
                $fileAr = self::generatePhotoPath($photo, $mainDir);
                $file_path = $fileAr['subdir'].'/'.$fileAr['file_name'];

                if (!file_exists($root.$file_path)){
                    $photo->move($root.$fileAr['subdir'], $fileAr['file_name']);
                }
            }
            
        } else {
            $file_path = '';
        }

        return $file_path;
    }

    static protected function generatePhotoPath($file, $mainDir){

        $salt = auth()->user()->id.'_2901';
            
        $file_name = md5($salt.'_'.$file->getClientOriginalName());
        $file_name = mb_substr($file_name, 0, 16).'.'.$file->extension();
        
        $mk_name = substr($file_name,0,3);

        $folder = public_path() . $mainDir . $mk_name;
        if (!is_dir($folder)){
            mkdir($folder, 755);
        }

        return [ 'subdir' => $mk_name, 'file_name' => $file_name ];
    }   
}
