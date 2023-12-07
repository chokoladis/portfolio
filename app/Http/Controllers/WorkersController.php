<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Workers\StoreRequest;
use App\Http\Requests\Workers\FilterRequest;
// use App\Http\Requests\Workers\DetailRequest;


class WorkersController extends Controller
{
    static $defaultFolderImg = '/storage/workers/img/';

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
    
        // todo
        $data['socials'] = !empty($data['socials']) ? json_encode($data['socials']) : null;
        
        preg_match_all('/[\d]/',$data['phone'],$arNumPhone);
        $data['phone'] = implode('',$arNumPhone[0]);

        $data['url_avatar'] = $this->getCreateImg($request);

        unset($data['photo']);

        $success = true;
        $res = Workers::firstOrCreate(
            [ 'user_id' => auth()->user()->id ],
            $data
        );

        if ($res->wasRecentlyCreated){
            $response = ['result' => 'Профиль Workers создан'];
        } else {
            $success = false;
            $response = ['error' => 'Профиль Workers с такими данными уже есть в БД'];
        }

        return HelperController::jsonRespose($success,$response);
    }

    public function getCreateImg($request){
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            $file_name = md5($photo->getClientOriginalName());
            $mk_name = substr($file_name,0,3);

            $folder = public_path() . self::$defaultFolderImg . $mk_name;
            if (!is_dir($folder)){
                mkdir($folder, 755);
            }

            $photo_path = $folder.'/'.$file_name;
            if (!file_exists($photo_path)){
                $photo->move(public_path() . self::$defaultFolderImg, $photo->getClientOriginalName());
            }
        } else {
            $photo_path = '';
        }

        return $photo_path;
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
     * Display the specified resource.
     */
    public function show(Workers $workers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workers $workers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workers $workers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workers $workers)
    {
        //
    }
}
