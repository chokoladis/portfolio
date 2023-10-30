<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuNavController;
use App\Models\Example_work;
use App\Models\Users;
// use App\Http\Controllers\HelperController;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    public function examplesWork(){
        $works = Example_work::paginate(5);

        return view('admin.works', compact('works'));
    }

    public function menu(){
        $menu = new MenuNavController();
        $listMenu = $menu->index();

        return view('admin.menu', compact('listMenu'));
    }

    public function users(){
        // $menu = new MenuNavController();
        // $listMenu = $menu->index();

        // return view('admin.menu', compact('listMenu'));
    }
}
