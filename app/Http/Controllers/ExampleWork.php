<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Example_work;
use App\Http\Controllers\HelperController;

class ExampleWork extends Controller
{
    public function index(){
        $works = Example_work::all();

        // 1 - pagename , 2 - var
        return view('works', compact('works'));
    }

    public function store(){
        
        $success = true;

        $data = request()->validate([
            'title' => 'string',
            'description' => 'string',
            // 'url_files' => 'string',
            'url_work' => 'string',
        ]);

        
        $res = Example_work::firstOrCreate(
            [ 'title' => $data['title']],
            $data
        );

        if ($res->wasRecentlyCreated){
            $response = ['result' => 'Данные успешно созданы'];
        } else {
            $success = false;
            $response = ['error' => 'Запись с данным заголовком уже есть в БД'];
        }

        return HelperController::jsonRespose($success,$response);
    }

    public function create(){
        return view('works.create');
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
