<?php

if (!function_exists('responseJson')) {
    function responseJson(bool $success, array|string $response = null, $error = null)
    {
        return response()
            ->json(['success' => $success,'result' => $response, 'error' => $error])
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
