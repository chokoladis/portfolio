<?php

namespace App\Http\Controllers;

use App\Models\Example_work;
use Illuminate\Http\Request;


class SearchController extends Controller
{
    private $models = [
        'Example_work',
        'Workers',
    ];

    public function index(Request $request){

        // todo sort by ?

        $data = $request->validate([
            'search' => ['required', 'min:3' , 'max:40', 'regex:/\d|\s|\w|\.|\,|\!|-|:/i']
        ]);

        if (!isset($data['search'])){
            abort(400);
        }

        $searchData = [];

        foreach($this->models as $i => $model){
            $modelClass = 'App\Models\\'.$model;
            $query = $modelClass::query();

            $fields = $modelClass::$searchable;

            foreach($fields as $field){
                $query->orWhere($field, 'like', '%'.$data['search'].'%');
            }

            $tempData = $query->paginate(); 
            foreach($tempData as $data){
                dump($data);
                $pasred = $data->only($fields);
                $searchData[$model][] = $pasred;
            }
        }

        $result = $searchData; 

        // dd($result);

        return view('search', compact('result'));

    }
}
