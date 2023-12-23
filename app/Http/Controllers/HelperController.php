<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class HelperController extends Controller
{
    public static $acceptFileSize = 3150000;
    public static $workerDirImg = '/storage/workers/img/';

    // public static function jsonRespose(bool $success = true,array|string $response = []){
    //     $res = [
    //         'success' => $success,
    //         'response' => $response
    //     ];

    //     return json_encode($res,JSON_UNESCAPED_UNICODE);        
    // }

    public static function getAdminUser(){
        $userObj = auth()->user();
        if ($userObj){
            return [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
            ];
        } else {
            return [
                'id' => 0,
                'name' => 'noname',
            ];
        }
    }

    public static function phoneOutFormated(string $from){
        $to = sprintf("%s (%s) %s-%s-%s",
            substr($from, 0, 1),
            substr($from, 1, 3),
            substr($from, 4, 3),
            substr($from, 7, 2),
            substr($from, 9)
        );
        return $to;
    }


    public function getNewPhotoPath($request, $propName, $mainDir){
        
        // $root = public_path() . self::$folderImg;
        $root = public_path() . $mainDir;        

        // if ($request->hasFile('photo')) {
        if ($request->hasFile($propName)) {
            
            $photo = $request->file($propName);

            if (is_array($photo)){

                $file_path = '';

                foreach ($photo as $file) {
                    
                    $fileAr = $this->generatePhotoPath($file, $mainDir);
                    $file_path .= $fileAr['subdir'].'/'.$fileAr['file_name'].', ';

                    if (!file_exists($root.$file_path)){
                        $file->move($root.$fileAr['subdir'], $fileAr['file_name']);
                    }
                }

                $file_path = trim($file_path);
                $file_path_len = mb_strlen($file_path);
                $file_path = mb_substr($file_path, 0, $file_path_len - 1);
            } else {
                $fileAr = $this->generatePhotoPath($photo, $mainDir);
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

    protected function generatePhotoPath($file, $mainDir){

        $salt = auth()->user()->id.'_'.time();
            
        $file_name = md5($salt.'_'.$file->getClientOriginalName());
        $file_name = mb_substr($file_name, 0, 16).'.'.$file->extension();
        
        $mk_name = substr($file_name,0,3);

        $folder = public_path() . $mainDir . $mk_name;
        if (!is_dir($folder)){
            mkdir($folder, 755);
        }

        return [ 'subdir' => $mk_name, 'file_name' => $file_name ];
    }

    // public function setCookie($name, $value, $minutes = 60){
    // //     // $cookie = Cookie($name, $value, $minutes);

    // //     // return $cookie;
    // //     // return response('setter cookie')->withCookie(cookie($name, $value, $minutes));
    //         return response('Welcome')->cookie($name, $value, $minutes);

    // //     // $response->cookie(cookie($name, $value, $minutes));
    // //     // return $response;
    // }

    // public function getCookie($name){
    //     $themeReq = new Request;
    //     $value = $themeReq->cookie($name);
    //     // echo $value.'<br>';
    //     // dump($_COOKIE);
    //     // $value = $_COOKIE["$name"] ?? 'dark';
    //     return $value;
    //  }

    // public function changeTheme(Request $themeReq){
    //     $data = $themeReq->validate([
    //         'activeTheme'=> 'string'
    //     ]);

    //     $theme = $data['activeTheme'];

    //     dump(self::getCookie($themeReq, 'theme'));
    //     // $boolSetter = setcookie('theme', $theme, time()+60*60*24*30 );

    //     // dump($boolSetter);
    //     // dump($_COOKIE);
    //     // if ($theme){
    //         $res = self::setCookie('theme', $theme, 60*24*30);
    //     //     // return self::jsonRespose(true, ['message' => 'Тема изменена на '.$theme]);
    //     // } else {
    //     //     $res = self::setCookie('theme', 'dark', 60*24*30);
    //     //     // return self::jsonRespose(false, ['message' => 'Ошибка при задании темы, установилась стандартная тема - dark']);
    //     // }

    //     dump(self::getCookie($themeReq, 'theme'));
    //     dd($res);
    // }
}
