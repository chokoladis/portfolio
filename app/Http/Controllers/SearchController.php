<?php

namespace App\Http\Controllers;

use App\Models\Example_work;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    private $models = [
        'Example_work' => 'crud.Example_work.title',
        'Workers' => 'crud.Workers.title',
    ];

    public function index(Request $request){

        $validate = $request->validate([
            'search' => ['required', 'string', 'min:3' , 'max:40', 'regex:/[а-яё|\d|\s|\w|\.|\,|\-_:\!\(\)]+/i'],
            'orderBy' => 'string|nullable',
            'sort' => 'string|nullable'
        ]);

        // todo sort by ?

        if (!isset($validate['search'])){
            abort(400);
        }

        $searchData = [];
        $total_count = 0;

        foreach($this->models as $model => $translation){
            $modelClass = 'App\Models\\'.$model;
            $query = $modelClass::query();

            $fields = $modelClass::$searchable;

            foreach($fields as $field){
                $query->orWhere($field, 'like', '%'.$validate['search'].'%');
            }
        
            $tempData = $query->paginate(); 
            $total_count += $tempData->count();

            foreach($tempData as $data){

                $parsed = [];
                $title = $data->getTitle();
                $route = route($modelClass::getRouteAddress(), $data);

                $arFiltredFields = [];
                $arTempFields = $data->only($fields);
                
                foreach($arTempFields as $code => $value ){
                    if (str_contains($value, $validate['search'])){
                        $arFiltredFields[$code] = $value;
                    }
                }
                
                $parsed = [
                    'contents' => $arFiltredFields,
                    'html_title' => $title,
                    'route' => $route
                ];

                $searchData[$model]['items'][] = $parsed;
            }

            $searchData[$model]['title'] = trans($translation);
        }

        $result = $searchData; 

        return view('search', compact('result','total_count'));

    }
}
