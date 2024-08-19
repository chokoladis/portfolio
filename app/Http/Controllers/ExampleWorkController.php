<?php

namespace App\Http\Controllers;

use App\Events\ViewsEvent;
use App\Http\Requests\ExampleWork\StoreRequest;
use App\Http\Requests\ExampleWork\UpdateRequest;
use App\Http\Requests\ExampleWork\FilterRequest;
use App\Models\Example_work;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ExampleWorkController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';


    public function index(FilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? Example_work::DEFAULT_PAGE;
        $perPage = $data['per_page'] ?? Example_work::DEFAULT_PERPAGE;
        
        $query = Example_work::query();
        
        $query = isset($data['work']) ? $this->filterByWork($query, $data['work']) : $query;
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;

        $arKeyCache = ['model' => 'Example_work', 'page' => $page,'per_page' => $perPage];

        $works = Example_work::getCacheList($arKeyCache, $query);

        return view('works.index', compact('works'));
    }

    public function detail(Example_work $work){

        Event(new ViewsEvent($work));

        $work = $work->getCacheOne($work->id);

        return view('works.detail', compact('work'));
    }

    public function filterByWork($query, $data){
        return $query->where('title', 'like', '%'.$data.'%')
                ->orWhere('description', 'like', '%'.$data.'%')
                ->orWhere('url_work', 'like', '%'.$data.'%')
                ->orWhere('slug', 'like', '%'.$data.'%');
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

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $fileService = new FileService($request, 'url_files', config('filesystems.clients.works'));
        $arResFiles = $fileService->handlerFiles();

        dd($arResFiles);

        if ($arResFiles['file_saved']){
            $result = 'Нектороые файлы не были записаны:';
        }

        if (!empty($arResFiles['errors'])){

        }
        // $data['url_files'] = ImageService::getNewPhotoPath($request, 'url_files', config('filesystems.img.works'));

        $data['slug'] = Str::slug($data['title'], '_', 'ru');

        $res = Example_work::firstOrCreate(
            [ 'slug' => $data['slug']],
            $data
        );

        if ($res->wasRecentlyCreated){
            self::$response = __('Данные успешно созданы');
        } else {
            self::$success = false;
            self::$error = __('Запись с данным заголовком уже есть в БД');
        }

        return responseJson(self::$success, self::$response, self::$error);
    }

    public function edit(Example_work $work){
        
        $this->authorize('modify', $work);

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
        
        $this->authorize('modify', $work);

        $data = $request->validated(); 

        $res = $work->update($data);

        if ($res){
            self::$response = 'Данные успешно обновлены';
        } else {
            self::$success = false;
            self::$error = 'При изменении данных возникла ошибка';
        }

        return responseJson(self::$success, self::$response, self::$error);
    }

    public function delete(Example_work $work){

        $this->authorize('delete', $work);
        
        if ($work->delete()){
            return responseJson(true, __('Запись успешно удаленна'));
        } else {
            return responseJson(false, '', __('Произошла ошибка при удалении'));
        }
    }

}
