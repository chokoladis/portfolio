<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;


class HelperController extends Controller
{
    public static $acceptFileSize = 3150000;

    public static function jsonRespose(bool $success = true,$response = []){
        $res = [
            'success' => $success,
            'response' => $response
        ];

        return json_encode($res,JSON_UNESCAPED_UNICODE);        
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
