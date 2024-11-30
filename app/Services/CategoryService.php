<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{

    public static function getList(array $params)
    {
        $cacheParams = array_merge($params, ['cache_entity' => 'category']);

        //        todo change ttl
        return Cache::remember(serialize($cacheParams), 86400, function () use ($params) {
            $query = Category::query();

            //        todo array or like
            foreach ($params as $key => $value){
                $query->where($key, $value);
            }

            return $query->get();
        });
    }

    static function isRowExists(array $data)
    {
        return Category::query()
            ->where('code', $data['code'])
            ->where('entity_code', $data['entity_code'])
            ->exists();
    }
}
