<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){

        // todo
        $data = $request->validate([
            'search' => 'required|min:3,max:40',
        ]);

        dd($data);

    }
}
