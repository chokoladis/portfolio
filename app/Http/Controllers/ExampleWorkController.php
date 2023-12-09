<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExampleWork\StoreRequest;
use App\Http\Requests\ExampleWork\UpdateRequest;
use App\Http\Requests\ExampleWork\FilterRequest;
use App\Models\Example_work;
use App\Models\User;
use App\Http\Controllers\HelperController;
use App\Http\Resources\ExampleWork\WorkResource;

class ExampleWorkController extends Controller
{
    static $folderImg = '/storage/works/img/';

    public function index(FilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;
        
        $query = Example_work::query();
        
        $query = isset($data['q']) ? $this->filterByQ($query, $data['q']) : $query;
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;
        
        $works = $query->paginate($perPage)->appends(request()->query());
        // $works = $query->paginate($perPage, ['*'], 'page', $page)->appends(request()->query());

        return view('works.index', compact('works'));
    }

    public function filterByQ($query, $data){
        return $query->where('title', 'like', '%'.$data.'%')
                ->orWhere('description', 'like', '%'.$data.'%')
                ->orWhere('url_work', 'like', '%'.$data.'%');
    }

    public function filterByProfile($query, $data){

        $arUsersId = $this->getUsersByLikeName($data);
        $arUsersId = !empty($arUsersId) ? $arUsersId : [0];

        return $query->whereIn('user_id', $arUsersId);
    }

    public function getUsersByLikeName(string $data) : array{

        $userFinder = User::query()
            ->where('name', 'like', '%'.$data.'%')
            ->orWhere('email', 'like', '%'.$data.'%')
            ->get();

        $arUsersId = [];

        foreach($userFinder as $user){
            if ($user->role !== 'admin'){
                $arUsersId[] = $user->id;
            }
        }

        return $arUsersId;
    }

    public function store(StoreRequest $request){
        
        $success = true;

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $data['url_files'] = $this->getCreateImg($request);

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

    public function getCreateImg($request){
        
        $url_files_path = '';
        $root = public_path() . self::$folderImg;

        if ($request->hasFile('url_files')) {
            $url_files = $request->file('url_files');
            if (is_array($url_files)){
                foreach ($url_files as $file) {
                    
                    $fileAr = $this->setPhotoPath($file);
                    $file_path = $fileAr['subdir'].'/'.$fileAr['file_name'];

                    if (!file_exists($root.$file_path)){
                        $file->move($root.$fileAr['subdir'], $fileAr['file_name']);
                    }
                    
                    $url_files_path .= $file_path.', ';
                }

                $url_files_path = trim($url_files_path);
                $url_files_path_len = mb_strlen($url_files_path);
                $url_files_path = mb_substr($url_files_path, 0, $url_files_path_len - 1);
            } else {
                $fileAr = $this->setPhotoPath($url_files);
                $file_path = $fileAr['subdir'].'/'.$fileAr['file_name'];

                if (!file_exists($root.$file_path)){
                    $url_files->move($root.$fileAr['subdir'], $fileAr['file_name']);
                }
                $url_files_path = $file_path;
            }
        }

        return $url_files_path;
    }

    protected function setPhotoPath($file){

        $salt = auth()->user()->id.'_'.time();
            
        $file_name = md5($salt.'_'.$file->getClientOriginalName());
        $file_name = mb_substr($file_name, 0, 12).'.'.$file->extension();
        
        $mk_name = substr($file_name,0,3);

        $folder = public_path() . self::$folderImg . $mk_name;
        if (!is_dir($folder)){
            mkdir($folder, 755);
        }

        return [ 'subdir' => $mk_name, 'file_name' => $file_name ];
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
}
