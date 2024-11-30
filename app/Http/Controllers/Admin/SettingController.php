<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function cacheClearAll()
    {
        Artisan::call('optimize:clear');

        return redirect()->route('admin.settings.index')->with('success', 'Cache cleared!');
    }
}
