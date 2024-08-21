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

    static $allowNoAuth = [
        'Example_work'
    ];

    public function index(Request $request){

        $validate = $request->validate([
            'search' => ['required', 'string', 'min:3' , 'max:40', 'regex:/[а-яё\d\s\w\.\,\-_:\!\(\)]+/i'],
            'page' => 'numeric|nullable|min:1',
            'per_page' => 'numeric|nullable|min:5|max:50',
            'orderBy' => 'string|nullable',
            'sort' => 'string|nullable'
        ], $messages = [
            'required' => 'Поле обязательно для заполнения',
            'min' => 'Слишком мало букав',
            'max' => 'Слишком много букав'
        ]);

        $validate['search']  = str_replace('%', '', $validate['search']);
        $searchForSql  = str_replace('_', '\_', $validate['search']);
        

        $searchData = [];
        $total_count = 0;
        $page = $validate['page'] ?? 1;
        $per_page = $validate['per_page'] ?? 5;
        $orderBy = $validate['orderBy'] ?? 'created_at';
        $sort = $validate['sort'] ?? 'asc';

        foreach($this->models as $model => $translation){

            if (!$this->checkPermission($model))
                continue;

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

                $arFiltredFields = [];

                foreach($tempData as $data){

                    foreach($data->only($fields) as $code => $value ){
                        if (str_contains($value, $validate['search'])){
                            $arFiltredFields[$code] = $value;
                        }
                    }

                    $views = $data->stats?->view_count;
                    $views = $views > 1000 ? $views / 1000 . 'k' : $views;
                    
                    $parsed = [
                        'contents' => $arFiltredFields ?? [],
                        'date_insert' => $data->created_at,
                        'views' => $views,
                        'html_title' => $data->getTitle(),
                        'route' => route($modelClass::getRouteAddress(), $data)
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

    static public function checkPermission(string $model){

        if (auth()->id() && auth()->user()->email_verified_at){
            return true;
        } elseif (!in_array($model, self::$allowNoAuth)){
            return false;
        } else {
            return true;
        }

    }
}
