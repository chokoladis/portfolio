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
            'search' => ['required', 'string', 'min:3' , 'max:40', 'regex:/[а-яё\d\s\w\.\,\-_:\!\(\)]+/i'],
            'page' => 'numeric|nullable|min:1',
            'per_page' => 'numeric|nullable|min:5|max:50',
            'orderBy' => 'string|nullable',
            'sort' => 'string|nullable'
        ]);

        if (!isset($validate['search'])){
            abort(400);
        }

        $validate['search']  = str_replace('%', '', $validate['search']);
        $searchForSql  = str_replace('_', '\_', $validate['search']);
        

        $searchData = [];
        $total_count = 0;
        $page = $validate['page'] ?? 1;
        $per_page = $validate['per_page'] ?? 5;
        $orderBy = $validate['orderBy'] ?? 'created_at';
        $sort = $validate['sort'] ?? 'asc';

        foreach($this->models as $model => $translation){
            $modelClass = 'App\Models\\'.$model;
            $fields = $modelClass::$searchable;

            $query = $modelClass::query();            

            foreach($fields as $field){
                $query->orWhere($field, 'like', '%'.$searchForSql.'%');
            }

            $skip = ($page - 1) * $per_page;
            $count = $query->count();
            $total_count += $count;

            $query = $query->orderBy($orderBy, $sort);
            $tempData = $query->skip($skip)->take($per_page)->get();

            if ($tempData->count()){

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
                        'date_insert' => $data->created_at,
                        'views' => $data->stats?->view_count,
                        'html_title' => $title,
                        'route' => $route
                    ];
        
                    $searchData[$model]['items'][] = $parsed;
                }
        
                $searchData[$model]['title'] = trans($translation);
            }
        }

        $pages = intval(round($total_count / $per_page));

        $result = $searchData;

        return view('search', compact('result', 'total_count', 'pages'));
    }

}
