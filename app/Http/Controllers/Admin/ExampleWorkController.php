<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExampleWork\StoreRequest;
use App\Http\Requests\ExampleWork\UpdateRequest;
use App\Http\Requests\ExampleWork\FilterRequest;
use App\Models\Example_work;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Services\ImageService;

class ExampleWorkController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';


    public function index(FilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;
        
        $query = Example_work::query();
        
        $query = isset($data['work']) ? $this->filterByWork($query, $data['work']) : $query;
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;
        $query = $this->filterByCreatedAt($query, $data);

        $works = $query->paginate($perPage)->appends(request()->query());

        return view('admin.works.index', compact('works'));
    }

    public function detail(Example_work $work){
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

    public function filterByCreatedAt($query, $data){

        $created_at_from = isset($data['created_at_from']) ? $data['created_at_from'] : null ;
        $created_at_to = isset($data['created_at_to']) ? $data['created_at_to'] : null ;

        if ($created_at_from || $created_at_to){

            $created_at_from = $created_at_from ?? '01.01.2023 00:00:00';
            $created_at_to = $created_at_to ?? now();

            $query->whereBetween('created_at', [$created_at_from, $created_at_to]);
        }

        return $query;
    }

    public function create(){
        return view('admin.works.create');
    }

    public function store(StoreRequest $request){

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $data['url_files'] = ImageService::getNewPhotoPath($request, 'url_files', config('filesystems.img.works'));

        $data['slug'] = Str::slug($data['title'], '_', 'ru');

        $res = Example_work::firstOrCreate(
            [ 'slug' => $data['slug']],
            $data
        );

        if ($res->wasRecentlyCreated){
            return redirect()->route('admin.works.index')->with('success', __('Данные успешно созданы'));
        } else {
            return redirect()->route('admin.menu.create')->with('error', __('Запись с данным заголовком уже есть в БД'));
        }
    }

    public function edit(Example_work $work){
        
        $this->authorize('mmodify', $work);

        $ar = [
            'id' => $work->id,
            'title' => $work->title,
            'description' => $work->description,
            'url_files' => $work->url_files,
            'url_work' => $work->url_work
        ];

        $json = json_encode($ar); 

        // todo admin lisense
        // Event(new ViewsEvent($work));

        return $json;
    }

    public function update(UpdateRequest $request, Example_work $work){
        
        $this->authorize('mmodify', $work);

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
