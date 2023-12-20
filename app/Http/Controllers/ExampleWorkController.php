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

    // todo
    // static $Helper = HelperController::class;

    // function __construct(){
    //     $this->Helper = new HelperController();
    //     parent::__construct();
    // }

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

        $helper = new HelperController;
        $data['url_files'] = $helper->getNewPhotoPath($request, 'url_files', self::$folderImg);

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
}
