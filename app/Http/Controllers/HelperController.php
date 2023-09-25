<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public static function jsonRespose(bool $success = true,$response = []){
        $res = [
            'success' => $success,
            'response' => $response
        ];

        return json_encode($res,JSON_UNESCAPED_UNICODE);        
    }

    public function changeTheme(Request $themeReq){
        $data = $themeReq->validate([
            'activeTheme'=> 'string'
        ]);

        $theme = $data['activeTheme'];

        if ($theme){
            setcookie('theme', $theme, time()+60*60*30, '/' );
            return self::jsonRespose(true, ['message' => 'Тема изменена на '.$theme]);
        } else {
            setcookie('theme', 'dark', time()+60*60*30, '/');
            return self::jsonRespose(false, ['message' => 'Ошибка при задании темы, установилась стандартная тема - dark']);
        }
    }
}
