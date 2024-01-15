<?php

namespace App\Http\Controllers;

use App\Models\MenuNav;
use Illuminate\Http\Request;
use App\Http\Requests\MenuNav\StoreRequest;
use App\Http\Requests\MenuNav\UpdateRequest;
use App\Http\Controllers\HelperController;

class MenuNavController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';

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
            self::$response = __('Данные успешно созданы');
        } else {
            self::$success = false;
            self::$error = __('Запись с данным заголовком уже есть в БД');
        }

        return responseJson(self::$success,self::$response, self::$error);
        
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
            self::$response = 'Данные успешно обновлены';
        } else {
            self::$success = false;
            self::$error = __('При изменении данных возникла ошибка');
        }

        return responseJson(self::$success,self::$response, self::$error);
    }

    /**
     * Update the specified resource in storage.
     */
    public function delete(MenuNav $menuNav)
    {        
        if ($menuNav->delete()){
            return responseJson(true, 'Запись успешно удаленна');
        } else {
            return responseJson(false, '', 'Произошла ошибка при удалении');
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
