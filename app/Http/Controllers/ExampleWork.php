<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Example_work;
class ExampleWork extends Controller
{
    public function index(){
        $works = Example_work::all();

        // 1 - pagename , 2 - var
        return view('works', compact('works'));
    }

    public function create(){
        $arr = [
            [
                'title' => 'Золотой Код',
                'description' => 'Работа с Wordpress, Bitrix, MODx, OpenCart',
                'url_files' => 'storage/image/zolotoykod.png',
                'url_work' => 'zolotoykod.ru',
            ],
            [
                'title' => 'Золотой Код 2',
                'description' => 'Работа 2',
                'url_files' => 'storage/image/zolotoykod2.png',
                'url_work' => 'zolotoykod.ru',
            ],
            [
                'title' => 'ASM',
                'description' => 'landing-page сбгсервис',
                'url_files' => 'storage/image/sbgservice.png',
                'url_work' => 'sbgservice.ru'
            ]
        ];

        foreach($arr as $item){
            Example_work::firstOrCreate([
                'title' => $item['title']
            ],
            $item);
        }
    }

    public function update(){

        $works = Example_work::find(1);
        $works->update(
            [
                'title' => 'Золотой Код upd',
                'description' => 'upd Работа с Wordpress, Bitrix, MODx, OpenCart',
                'url_files' => 'storage/image/zolotoykod.png',
                'url_work' => 'zolotoykod.ru',
            ]
        );

    }

    public function delete(){
        $works = Example_work::find(1);
        $works->delete();
    }

    public function deleteAll(){
        $works = Example_work::all();
        foreach($works as $work){
            $work->delete();
        }
        
    }
}
