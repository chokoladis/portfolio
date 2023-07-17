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

    public function store(Request $request){
        
        $success = true;
        $url_files_path = '';

        $data = request()->validate([
            'title' => 'string',
            'description' => 'string',
            'url_files' => '',
            'url_work' => 'string',
        ]);

        if ($request->hasFile('url_files')) {
            $url_files = $request->file('url_files');
            if (is_array($url_files)){
                foreach ($url_files as $file) {
                    $file->move(public_path() . '/storage/works/img/', $file->getClientOriginalName());
                    $url_files_path .= '/storage/works/img/'.$file->getClientOriginalName().', ';
                }

                $url_files_path = trim($url_files_path);
                $url_files_path_len = mb_strlen($url_files_path);
                $url_files_path = mb_substr($url_files_path, 0, $url_files_path_len - 1);
            } else {
                $url_files->move(public_path() . '/storage/works/img/', $url_files->getClientOriginalName());
                $url_files_path = '/storage/works/img/'.$url_files->getClientOriginalName();
            }
            
        }
        $data['url_files'] = $url_files_path;

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

    public function update(Example_work $work){

        // validate
        $works = Example_work::find($work);
        $works->update(
            [
                'title' => 'Золотой Код upd',
                'description' => 'upd Работа с Wordpress, Bitrix, MODx, OpenCart',
                'url_files' => 'storage/image/zolotoykod.png',
                'url_work' => 'zolotoykod.ru',
            ]
        );

    }

    public function delete(Example_work $work){

        if ($work->delete()){
            return HelperController::jsonRespose(true, ['result' => 'Запись успешно удаленна']);
        } else {
            return HelperController::jsonRespose(false, ['error' => 'Произошла ошибка при удалении']);
        }
    }

    public function deleteAll(){
        $works = Example_work::all();
        foreach($works as $work){
            $work->delete();
        }
        
    }

    public function worksList(){
        $works = Example_work::all();
        return view('compiled.works', compact('works'));
    }
}
