<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;


class HelperController extends Controller
{
    public static function jsonRespose(bool $success = true,$response = []){
        $res = [
            'success' => $success,
            'response' => $response
        ];

        return json_encode($res,JSON_UNESCAPED_UNICODE);        
    }

    // public function setCookie($name, $value, $minutes = 60){
    //     // $cookie = Cookie($name, $value, $minutes);

    //     // return $cookie;
    //     // return response('setter cookie')->withCookie(cookie($name, $value, $minutes));
    //     // $response->cookie(cookie($name, $value, $minutes));
    //     // return $response;
    // }

    // public function getCookie(Request $request, $name){
    //     $value = $request->cookie($name);
    //     echo $value.'<br>';
    //     $value = Cookie::get($name);
    //     echo $value;
    //  }

    public function changeTheme(Request $themeReq){
        $data = $themeReq->validate([
            'activeTheme'=> 'string'
        ]);

        $theme = $data['activeTheme'];

        // if ($theme){
        //     $res = self::setCookie('theme', $theme, 60*24*30);
        //     // return self::jsonRespose(true, ['message' => 'Тема изменена на '.$theme]);
        // } else {
        //     $res = self::setCookie('theme', 'dark', 60*24*30);
        //     // return self::jsonRespose(false, ['message' => 'Ошибка при задании темы, установилась стандартная тема - dark']);
        // }

        // dd(self::getCookie($themeReq, 'theme'));
        // dd($res);
    }
}
