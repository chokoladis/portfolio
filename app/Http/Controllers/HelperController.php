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
}
