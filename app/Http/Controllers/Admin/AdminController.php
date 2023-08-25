<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    public function ExamplesWork(){
        return view('admin.examples_work');
    }
}
