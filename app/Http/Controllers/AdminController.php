<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuNavController;
use App\Http\Requests\ExampleWork\FilterRequest as WorkFilterRequest;
use App\Http\Requests\Workers\FilterRequest as WorkersFilterRequest;
use App\Models\Example_work;
use App\Models\User;
use App\Models\Workers;

// use App\Http\Controllers\HelperController;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    public function examplesWork(WorkFilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;
        

        $query = Example_work::query();
        $queryUser = User::query();

        if (isset($data['q'])){
            $query->where('title', 'like', '%'.$data['q'].'%')
                ->orWhere('description', 'like', '%'.$data['q'].'%')
                ->orWhere('url_work', 'like', '%'.$data['q'].'%');
        }
        if (isset($data['profile'])){
            
            $queryUser->where('name', 'like', '%'.$data['profile'].'%')
                ->orWhere('email', 'like', '%'.$data['profile'].'%');

            $userFinder = $queryUser->get();
            $userID = 0;

            foreach($userFinder as $user){
                if ($user->role !== 'admin'){
                    $userID = $user->id;
                }
            }

            if ($userID !== 0){
                $query->where('user_id', $userID);
            } else {
                // empty search
            }

        }

        $works = $query->paginate($perPage)->appends(request()->query());

        return view('admin.works', compact('works'));
    }

    public function menu(){
        $menu = new MenuNavController();
        $listMenu = $menu->index();

        return view('admin.menu', compact('listMenu'));
    }

    public function workers(WorkersFilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        $query = Workers::query();
        $workers = $query->paginate($perPage)->appends($data);

        return view('admin.workers', compact('workers'));
    }

    public function users(){
        // $menu = new MenuNavController();
        // $listMenu = $menu->index();

        // return view('admin.menu', compact('listMenu'));
    }
}
