<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class MenuNav extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','deleted_at'];
    static $formHidden = ['created_at','updated_at','deleted_at'];

    // protected $attributes = [
    //     'name' => 'string',
    //     'link' => 'string', 
    //     'role' => 'string',
    //     // 'active' => 'boolean',
    //     'sort' => 'int'
    // ];

    protected $casts = [
        'name' => 'string',
        'link' => 'string', 
        'role' => 'string',
        // 'active' => 'boolean',
        'sort' => 'int'
    ];

    static $nameColumns = [
        'name' => 'Наименование',
        'link' => 'Ссылка', 
        'role' => 'Роль',
        'active' => 'Активность',
        'sort' => 'Сортировка'
    ];
    
    public function getColumns(){

        $tableName = $this->getTable();
  
        $columns = Schema::getColumnListing($tableName);
        
        foreach($columns as $col){
            if ($col !== 'id'
                && array_key_exists($col,self::$nameColumns)){
                $res[$col]['name_ru'] = self::$nameColumns[$col];
                $res[$col]['type'] = Schema::getColumnType($tableName, $col);
            }
        }

        return $res;
    }

    public function getActive(){
        $query = MenuNav::query();
        $list = $query->where('active', 1)->get();
        return $list;
    }
}
