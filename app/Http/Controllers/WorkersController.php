<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Workers\StoreRequest;
use App\Http\Requests\Workers\FilterRequest;
use App\Http\Controllers\HelperController;
// use App\Http\Requests\Workers\DetailRequest;


class WorkersController extends Controller
{
    static $folderImg = '/storage/workers/img/';
    static $error = '';
    static $success = true;
    static $response = '';

    const DEFAULT_SOCIAL_LIST = ['telegram', 'github', 'hh', 'kwork'];

    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $workerById = null;
        if (auth()->user()){
            $userId = auth()->user()->id;
            $workerById = Workers::where('user_id', '=', $userId)->first();
        }

        $data = $request->validated();

        $queryWorkers = Workers::query();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        if (isset($data['profile'])){
            $queryWorkers = $this->filterByProfile($queryWorkers, $data['profile']);
        }

        $workers = $queryWorkers->paginate($perPage)->appends(request()->query());
        
        return view('workers.index', compact('workers', 'workerById'));
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
    
        $data['socials'] = $this->getSocials($data['socials']);
        $phone = $this->getNumbers($data['phone']);
        $data['phone'] = !empty($phone) ? implode('', $phone) : null;

        // todo
        $helper = new HelperController();
        $data['url_avatar'] = $helper->getNewPhotoPath($request, 'photo', self::$folderImg);

        unset($data['photo']);

        $res = Workers::firstOrCreate(
            [ 'user_id' => auth()->user()->id ],
            $data
        );

        if ($res->wasRecentlyCreated){
            self::$response = __('Профиль Workers создан');
        } else {
            self::$success = false;
            self::$error = __('Профиль Workers с такими данными уже есть в БД');
        }

        return responseJson(self::$success, self::$response, self::$error);
    }

    public function getSocials(array|null $data){

        if ($data === null)
            return $data;

        $data['telegram'] = HelperController::replaceArrobaToLink($data['telegram'], 't.me');
        $data['github'] = HelperController::replaceArrobaToLink($data['github'], 'github.com');
        
        // dd($data);
        $socials = json_encode($data);
        // dd($socials);

        return $socials;
    }

    public function detail(Workers $worker)
    {
        $workerNew = Workers::find($worker->id);
 
        $worker = [
            'id' => $workerNew->id,
            'name' => $workerNew->user->name,
            'url_avatar' => $workerNew->url_avatar,
            'phone' => $workerNew->phone,
            'about' => $workerNew->about,
            'socials' => $workerNew->socials
        ];

        return view('workers.detail', compact('worker'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workers $workers)
    {
        //
    }
}
