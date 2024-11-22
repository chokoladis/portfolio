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
if (!function_exists('getUserRole')) {
    function getUserRole()
    {
        return auth()->user()?->role ?? 'guest';
    }
}


// optimizer - mergeSort
// set_time_limit(120);
// $arr = range(0,999999);
// shuffle($arr);

// // dump($arr);

// $start_time = hrtime(true);
// asort($arr);
// $end_time = hrtime(true);

// $execution_time = $end_time - $start_time;
// $sec = $execution_time / 1e9;

// echo '1 end - '. $sec.' sec';

// $ost = count($arr)%2;

// $arr1 = array_slice($arr, 0, (count($arr)/2) );
// $arr2 = array_slice($arr, (count($arr)/2), count($arr)-1 );

// $start_time = hrtime(true);

// asort($arr1);
// asort($arr2);

// $i = $j = 0;
// $result = [];
// for ($k=0; $k < count($arr); $k++) {

//     if (isset($arr1[$i]) && $arr1[$i] < $arr2[$j]){
//         $result[$k] = $arr1[$i];
//         $i++;
//     } else {
//         $result[$k] = $arr2[$j];
//         $j++;
//     }
// }

// //
// $end_time = hrtime(true);
// $execution_time = $end_time - $start_time;
// $sec = $execution_time / 1e9;
// echo '2 end - '. $sec. ' sec';

// // dump($arr1, $arr2, $result);
