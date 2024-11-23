<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HelperController extends Controller
{
    public function index(){
        return view('admin.home');
    }
}
