<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class HelperController extends Controller
{
    const ORDER_BY = [
        // 'view_count' => 'По просмотрам',
        'created_at' => 'По дате добавления'
    ];

    const SORT = [
        'asc' => 'По возрастанию',
        'desc' => 'По убыванию'
    ];

    const PER_PAGE = [
        5, 10, 15, 20
    ];

    const GENERAL_PATH = 'storage/general/';

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

    public static function filterByCreatedAt($query, $data){

        $created_at_from = isset($data['created_at_from']) ? $data['created_at_from'] : null ;
        $created_at_to = isset($data['created_at_to']) ? $data['created_at_to'] : null ;

        if ($created_at_from || $created_at_to){

            $created_at_from = $created_at_from ?? '01.01.2023 00:00:00';
            $created_at_to = $created_at_to ?? now();

            $query->whereBetween('created_at', [$created_at_from, $created_at_to]);
        }

        return $query;
    }

    static function getTheme()
    {
        return request()->cookie('theme') ?? 'dark';
    }

    static function getMainSliderFiles(string $folder)
    {
        $pathDir = self::GENERAL_PATH.$folder.'/';
        $files = [];

        foreach (new \DirectoryIterator($pathDir) as $file) {
            if(!$file->isDot())
                $files[] = $pathDir.$file->getFilename();
        }

        return $files;
    }
}
