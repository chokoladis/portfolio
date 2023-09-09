<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Example_work;
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
}
