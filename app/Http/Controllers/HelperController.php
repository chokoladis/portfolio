<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class HelperController extends Controller
{
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

    public static function replaceArrobaToLink(string $str, string $link){

        if (str_contains($str, 'https://')){

            if(str_contains($str, $link)){
                $res = $str;
            } else {
                $str = str_replace('https://','',$str);
                $res = 'https://'.$link.'/'.$str;
            }

        } else {

            if(str_contains($str, $link)){
                $res = $str;
            } else if (str_contains($str, '@')){
                $res = str_replace('@', $link.'/' , $str);
            } else {
                $res = $link.'/'.$str;
            }

            $res = 'https://' . $res;
        }

        return $res;
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
