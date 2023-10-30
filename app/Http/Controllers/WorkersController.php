<?php

namespace App\Http\Controllers;

use App\Models\Workers;
use Illuminate\Http\Request;
use App\Http\Requests\Workers\StoreRequest;

class WorkersController extends Controller
{
    static $defaultFolderImg = '/storage/workers/img/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workers = Workers::paginate(5);

        return view('workers.index', compact('workers'));
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

        if (isset($data['photo'])){
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
            
                $photo->move(public_path() . self::$defaultFolderImg, $photo->getClientOriginalName());
                $photo_path = self::$defaultFolderImg.$photo->getClientOriginalName();
            }
            $data['url_avatar'] = $data['photo'];
            unset($data['photo']);
        }

        if (isset($data['phone'])){
            $nubmers = preg_replace('/\D/','',$data['phone']);
            if (strlen($nubmers) !== 11){
                $success = false;
                $response = ['error' => 'mess'];
            }
        }

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
        // dd($data);
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
