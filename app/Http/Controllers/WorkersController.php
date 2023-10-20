<?php

namespace App\Http\Controllers;

use App\Models\Workers;
use Illuminate\Http\Request;
use App\Http\Requests\Workers\StoreRequest;

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
    public function store(StoreRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        // path: "/private/var/folders/nl/50_tm4b52js54g_5308m8jzr0000gn/T"
        // filename: "phpKd8sPI"
        // basename: "phpKd8sPI"
        // pathname: "/private/var/folders/nl/50_tm4b52js54g_5308m8jzr0000gn/T/phpKd8sPI"
        dd($data);
        // todo
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
