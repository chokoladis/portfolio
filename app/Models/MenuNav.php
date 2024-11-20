<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class MenuNav extends Model
{
    use HasFactory;
    use SoftDeletes;

    const LIST_ROLE = [
        'guest', 'user', 'admin'
    ];

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

    /**
     * @return mixed[]
     */
    static function getActive(): mixed
    {
        return Cache::remember('main_menu_active', 86400, function () {
            return static::query()
                ->where('active', 1)
                ->get() ?? [];
        });
    }


}
