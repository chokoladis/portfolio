<?php

namespace App\Http\Controllers;

use App\Models\MenuNav;
use Illuminate\Http\Request;

class MenuNavController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MenuNav::all();
    }

    public function getActive(){
        $query = MenuNav::query();
        $list = $query->where('active', 1);
        return $list;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuNav $menuNav)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuNav $menuNav)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuNav $menuNav)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuNav $menuNav)
    {
        //
    }
}
