<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function cacheClearAll()
    {
        Artisan::call('cache:clear');
    }
}
