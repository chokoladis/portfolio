<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuNav;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuNav\StoreRequest;
use App\Http\Requests\MenuNav\UpdateRequest;


class MenuNavController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // todo filter
        $listMenu = MenuNav::all();

        return view('admin.menu.index', compact('listMenu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $model = new MenuNav();
        $columns = $model->getColumns();

        return view('admin.menu.create', compact('columns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        
        $ar = [
            'name' => $data['name'],
            'link' => $data['link'],
            'active' => $data['active'],
        ];

        if (isset($data['role']))
            $ar = array_merge($ar,['role' => $data['role'],]);

        if (isset($data['sort']))
            $ar = array_merge($ar,['sort' => $data['sort'],]);

        $res = MenuNav::firstOrCreate( ['link' => $data['link']], $ar );

        if ($res->wasRecentlyCreated){
            return redirect()->route('admin.menu.index')->with('success', __('Данные успешно созданы'));
        } else {
            return redirect()->route('admin.menu.create')->with('error', __('Запись с данным заголовком уже есть в БД'));
        }        
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
