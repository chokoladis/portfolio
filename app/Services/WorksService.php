<?php

namespace App\Services;

use App\Models\Example_work;
use App\Traits\Errors;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class WorksService
{
    use Errors;

    public function getList(array $arKeyCache, Builder $query)
    {
        $key = serialize($arKeyCache);

        $diffs = array_diff_key(request()->all(), $arKeyCache);

        if (empty($diffs)) {
            return Cache::remember($key, 7200, function () use ($arKeyCache, $query) {
                return $query->paginate($arKeyCache['per_page'])->appends(request()->query());
            });
        } else {
            return $query->paginate($arKeyCache['per_page'])->appends(request()->query());
        }
    }

    public function getById(int $id)
    {
        $key = static::class . '_' . $id;

        return Cache::remember($key, 21600, function () use ($id) {
            return Example_work::query()->where('active', 1)->where('id',$id);
        });
    }

    public function add($request, array $data)
    {
        try {
            [$data, $fileErrors] = $this->prepareDataAdd($request, $data);

            $result = Example_work::firstOrCreate(
                [ 'slug' => $data['slug']],
                $data
            );

            if ($result->wasRecentlyCreated){
                return [true, $fileErrors];
            } else {
                // delete created uploading files
                return [false,
                    [$this->compileErrorFromArray(['code' => 'title', 'message' => __('Запись с данным заголовком уже есть в БД') ])]
                ];
            }
        } catch(\Throwable $throwable){
            return [false, [$this->compileError($throwable->getCode(), $throwable->getMessage())] ];
        }
    }

    public function prepareDataAdd($request, array $data)
    {
        $data['user_id'] = auth()->id();

        $fileService = new FileService($request, 'url_files', 'Example_work');
        [$arSaved, $arErrors] = $fileService->handlerFiles();
        $arFilesPath = [];

        if (!empty($arSaved)){
            foreach ($arSaved as $value) {
                $arFilesPath[] = $value['path'];
            }
        }

        $data['url_files'] = implode(',', $arFilesPath);

        $data['slug'] = Str::slug($data['title'], '_', 'ru');

        return [$data, $arErrors];
    }
}
