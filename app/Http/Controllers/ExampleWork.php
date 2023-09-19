<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExampleWork\StoreRequest;
use App\Http\Requests\ExampleWork\UpdateRequest;
use App\Http\Requests\ExampleWork\FilterRequest;
use App\Models\Example_work;
use App\Models\User;
use App\Http\Controllers\HelperController;

class ExampleWork extends Controller
{
    public function index(FilterRequest $request){

        $data = $request->validated();
        
        // // данные не очищаются
        // dump($data);

        $query = Example_work::query();
        $queryUser = User::query();

        if (isset($data['q'])){
            $query->where('title', 'like', '%'.$data['q'].'%')
                ->orWhere('description', 'like', '%'.$data['q'].'%')
                ->orWhere('url_work', 'like', '%'.$data['q'].'%');
        }
        if (isset($data['profile'])){
            
            $queryUser->where('name', 'like', '%'.$data['profile'].'%')
                ->orWhere('email', 'like', '%'.$data['profile'].'%');

            $userFinder = $queryUser->get();
            $userID = 0;

            foreach($userFinder as $user){
                if ($user->role != 'admin'){
                    $userID = $user->id;
                }
            }

            if ($userID != 0){
                $query->where('user_id', $userID);
            } else {
                // empty search
            }

        }

        $works = $query->paginate(5);

        // 1 - pagename , 2 - var
        return view('works.index', compact('works'));
    }

    public function store(StoreRequest $request){
        
        $success = true;
        $url_files_path = '';

        $data = $request->validated();

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

    public function edit(Example_work $work){

        $ar = [
            'id' => $work->id,
            'title' => $work->title,
            'description' => $work->description,
            'url_files' => $work->url_files,
            'url_work' => $work->url_work
        ];

        $json = json_encode($ar); 

        return $json;
    }

    public function update(UpdateRequest $request, Example_work $work){
        
        $success = true;
        
        $data = $request->validated(); 

        $res = $work->update($data);

        if ($res){
            $response = ['result' => 'Данные успешно обновлены'];
        } else {
            $success = false;
            $response = ['error' => 'При изменении данных возникла ошибка'];
        }

        return HelperController::jsonRespose($success,$response);
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
