<?php

namespace App\Http\Controllers;

use App\Models\Workers;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workers = Workers::paginate(5);

        return view('workers.index', compact('workers'));
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
    public function show(Workers $workers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workers $workers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workers $workers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workers $workers)
    {
        //
    }
}
