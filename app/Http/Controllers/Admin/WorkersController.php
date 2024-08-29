<?php

namespace App\Http\Controllers\Admin;

use App\Events\ViewsAdminEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workers;
use App\Http\Requests\Workers\StoreRequest;
use App\Http\Requests\Workers\FilterRequest;
use App\Http\Controllers\HelperController;
use App\Services\ImageService;
use Illuminate\Support\Str;


class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $query = Workers::query();

        if (isset($data['show_deleted']) && $data['show_deleted'])
            $query = $query->withTrashed();
        
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;
        $query = HelperController::filterByCreatedAt($query, $data);

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        $workers = $query->paginate($perPage)->appends(request()->query());
        
        return view('admin.workers.index', compact('workers'));
    }

    public function filterByProfile($queryWorkers, $fieldProfile){

        if ($this->isUsername($fieldProfile)){

            $arUsersId = $this->getUsersByLikeName($fieldProfile);
            $arUsersId = !empty($arUsersId) ? $arUsersId : [0];

            $queryWorkers->whereIn('user_id', $arUsersId);

        } else {

            $matches = $this->getNumbers($fieldProfile);
            
            if (!empty($matches)){
                $phone = implode('', $matches);
                $queryWorkers->where('phone', 'like', '%'.$phone.'%');
            }
        }

        return $queryWorkers;
    }

    public function isUsername(string $data) : bool {

        preg_match('/[a-zA-Z]+/', $data, $matches_letter);
        return !empty($matches_letter) ? true : false;
    }

    public function getNumbers(string $data) : array {

        preg_match_all('/[\d]/', $data, $matches_num);
        if(!empty($matches_num)){
            // && count($matches_num[0]) > 3){            
            return $matches_num[0];
        } else {
            return [];
        }
    }

    public function getUsersByLikeName(string $name) : array{

        $userFinder = User::query()
            ->where('name', 'like', '%'.$name.'%')
            ->get();

        $arUsersId = [];

        foreach($userFinder as $user){
            if ($user->role !== 'admin'){
                $arUsersId[] = $user->id;
            }
        }

        return $arUsersId;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
    
        $data['socials'] = isset($data['socials']) ? $this->getSocials($data['socials']) : null;
        $phone = $this->getNumbers($data['phone']);
        $data['phone'] = !empty($phone) ? implode('', $phone) : null;

        $data['url_avatar'] = ImageService::getNewPhotoPath($request, 'photo', config('filesystems.clients.workers'));

        unset($data['photo']);

        $data['code'] = self::getTransliteName();

        $res = Workers::firstOrCreate(
            [ 'user_id' => auth()->user()->id ],
            $data
        );

        // if ($res->wasRecentlyCreated){
        //     self::$response = __('Профиль Workers создан');
        // } else {
        //     self::$success = false;
        //     self::$error = __('Профиль Workers с такими данными уже есть в БД');
        // }

        // return responseJson(self::$success, self::$response, self::$error);
    }

    public function getSocials(array|null $data){

        if ($data === null)
            return $data;

        if (isset($data['telegram']))
            $data['telegram'] = HelperController::replaceArrobaToLink($data['telegram'], 't.me');
        
        if(isset($data['github']))
            $data['github'] = HelperController::replaceArrobaToLink($data['github'], 'github.com');

        return json_encode($data);
    }

    public function edit(Workers $worker)
    {
        $this->authorize('modify', $worker);

        Event(new ViewsAdminEvent($worker));

        $works = $worker->getWorks();
 
        return view('admin.workers.edit', compact('worker', 'works')); //'workerAr',
    }

    public function update(Workers $worker)
    {
        dd($worker);

        return view('admin.workers.edit', compact('worker','works'));
    }

    public function delete($worker){

        dd($worker);

    }

    public function forceDelete($worker){

        dd($worker);
        
    }

    public function getTransliteName(){

        $user = User::find(auth()->user()->id, 'name');
        $code = Str::slug($user->name, '_', 'ru');
        return $code;
    }
}
