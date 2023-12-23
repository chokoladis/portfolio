<?php

namespace App\Http\Controllers;

use App\Models\MenuNav;
use Illuminate\Http\Request;
use App\Http\Requests\MenuNav\StoreRequest;
use App\Http\Requests\MenuNav\UpdateRequest;
use App\Http\Controllers\HelperController;

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
        $list = $query->where('active', 1)->get();
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
    public function store(StoreRequest $request)
    {
        $success = true;
        $data = $request->validated();

        $res = MenuNav::firstOrCreate(
            ['link' => $data['link']], 
            [
                'name' => $data['name'],
                'link' => $data['link'],
                'role' => $data['role'],
                'active' => $data['active'],
                'sort' => $data['sort']
            ]
        );

        if ($res->wasRecentlyCreated){
            $response = ['result' => 'Данные успешно созданы'];
        } else {
            $success = false;
            $response = ['error' => 'Запись с данным заголовком уже есть в БД'];
        }

        return response()->json(['success' => $success,'response' => $response]);
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
        $ar = [
            'id' => $menuNav->id,
            'name' => $menuNav->name,
            'link' => $menuNav->link,
            'role' => $menuNav->role,
            'active' => $menuNav->active,
            'sort' => $menuNav->sort
        ];

        $json = json_encode($ar); 

        return $json;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, MenuNav $menuNav)
    {
        $success = true;
        
        $data = $request->validated(); 

        $res = $menuNav->update($data);

        if ($res){
            $response = ['result' => 'Данные успешно обновлены'];
        } else {
            $success = false;
            $response = ['error' => 'При изменении данных возникла ошибка'];
        }

        return response()->json(['success' => $success,'response' => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function delete(MenuNav $menuNav)
    {        
        if ($menuNav->delete()){
            return response()->json(['success' => true,'response' => ['result' => 'Запись успешно удаленна']]);
        } else {
            return response()->json(['success' => false,'response' => ['error' => 'Произошла ошибка при удалении']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuNav $menuNav)
    {
        //
    }
}
