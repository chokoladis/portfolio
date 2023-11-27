<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Workers\StoreRequest;
// use App\Http\Requests\Workers\DetailRequest;


class WorkersController extends Controller
{
    static $defaultFolderImg = '/storage/workers/img/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workerById = null;
        if (auth()->user()){
            $userId = auth()->user()->id;
            $workerById = Workers::where('user_id', '=', $userId)->first();
        }

        // $queryWorkers = Workers::query();
        // $queryUser = User::query();

        // if (isset($data['profile'])){
            
        //     // preg_match_all('/[\d]/');
        //     // $data['profile']

        //     // queryWorkers

        //     $queryUser->where('name', 'like', '%'.$data['profile'].'%');

        //     $userFinder = $queryUser->get();
        //     $arUsersId = [];

        //     foreach($userFinder as $user){
        //         if ($user->role !== 'admin'){
        //             $arUsersId[] = $user->id;
        //         }
        //     }

        //     if (!empty($arUsersId)){
        //         $query->where('user_id', $arUsersId);
        //     } else {
        //         // empty search
        //     }

        // }
        // $workers = $queryWorkers->paginate($perPage)->appends(request()->query());


        $workers = DB::table('workers')
                    ->join('users', 'workers.user_id', '=', 'users.id')
                    ->select('users.name', 'workers.*')
                    ->paginate(5);

        return view('workers.index', compact('workers', 'workerById'));
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
            
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            $photo_path = self::$defaultFolderImg.$photo->getClientOriginalName();
            if (!file_exists(public_path() . $photo_path)){
                $photo->move(public_path() . self::$defaultFolderImg, $photo->getClientOriginalName());
            }
        }
        $data['url_avatar'] = $photo_path;
    
        $data['socials'] = !empty($data['socials']) ? json_encode($data['socials']) : null;

        if ($success === null){

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
        }

        return HelperController::jsonRespose($success,$response);
    }

    public function detail(Workers $worker)
    {
        $workerNew = DB::table('workers')
                ->join('users', 'workers.user_id', '=', 'users.id')
                ->select('users.name', 'workers.*')
                ->where('workers.id', '=', $worker->id)->first();
                
        $worker = [
            'id' => $workerNew->id,
            'name' => $workerNew->name,
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
