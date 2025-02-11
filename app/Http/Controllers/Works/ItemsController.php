<?php

namespace App\Http\Controllers\Works;

use App\Events\ViewsEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleWork\StoreRequest;
use App\Http\Requests\ExampleWork\UpdateRequest;
use App\Http\Requests\ExampleWork\FilterRequest;
use App\Models\Example_work;
use App\Models\User;
use App\Services\WorksService;
use App\Traits\Errors;
use Predis\Command\Traits\BloomFilters\Error;

class ItemsController extends Controller
{
    use Errors;

    public WorksService $worksService;

    public  function  __construct()
    {
        $this->worksService = new WorksService();
    }


    public function index(FilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? Example_work::DEFAULT_PAGE;
        $perPage = $data['per_page'] ?? Example_work::DEFAULT_PERPAGE;

        $query = Example_work::query()->where('active', 1);

        $query = isset($data['work']) ? $this->filterByWork($query, $data['work']) : $query;
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;

        $arParams = ['model' => 'Example_work', 'page' => $page,'per_page' => $perPage];

        $works = $this->worksService->getList($arParams, $query);

        return view('works.index', compact('works'));
    }

    public function detail(Example_work $work){

        Event(new ViewsEvent($work));

        $work = $this->worksService->getById((int)$work->id);

        return view('works.detail', compact('work'));
    }

    public function store(StoreRequest $request){

        $data = $request->validated();

        [$success, $errors] = $this->worksService->add($request, $data);

        if ($success) {
            return responseJson($success, __('Данные успешно созданы'));
        } else {
            return responseJson($success, error: $errors, status: 400);
        }
    }

    public function edit(Example_work $work){

        $this->authorize('modify', $work);

        $data = [
            'id' => $work->id,
            'title' => $work->title,
            'description' => $work->description,
            'url_files' => $work->url_files,
            'url_work' => $work->url_work
        ];

        return json_encode($data);
    }

    public function update(UpdateRequest $request, Example_work $work){

        $this->authorize('modify', $work);

        $data = $request->validated();

        if ($work->update($data)){
            return responseJson(false, __('controllers.action.success', ['action' => 'Изменение']));
        } else {
            return responseJson(false, error: [$this->getUnknownError('изменении')]);
        }
    }

    public function delete(Example_work $work){

        $this->authorize('delete', $work);

        if ($work->delete()){
            return responseJson(true, __('controllers.action.success', ['action' => 'Удаление']));
        } else {
            return responseJson(false, [$this->getUnknownError('удалении')]);
        }
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

    public function getUsersByLikeName(string $data) : array
    {
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

}
