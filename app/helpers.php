<?php

use App\Services\FileService;

if (!function_exists('responseJson')) {
    function responseJson(bool $success = true, array|string $response = null, $error = null, $status = '200')
    {
        return response()
            ->json(['success' => $success,'result' => $response, 'error' => $error])
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE)
            ->setStatusCode($status);
    }
}
if (!function_exists('is_video')) {
    function is_video(string $filepath) : bool {

        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
    
        return in_array($ext, FileService::$videoExt);
    }
}
if (!function_exists('is_image')) {
    function is_image(string $filepath) : bool {

        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
    
        return in_array($ext, FileService::$imgExt);
    }
}