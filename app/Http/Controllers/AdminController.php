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

    public function workers(WorkersFilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        $query = Workers::query();
        $workers = $query->paginate($perPage)->appends($data);

        return view('admin.workers.index', compact('workers'));
    }

    public function users(){
        // $menu = new MenuNavController();
        // $listMenu = $menu->index();

        // return view('admin.menu', compact('listMenu'));
    }
}
