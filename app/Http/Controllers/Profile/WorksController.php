<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Example_work;
use App\Http\Controllers\Profile\IndexController;
use App\Http\Requests\Profile\WorksRequest;
use App\Http\Requests\Profile\WorkUpdateRequest;
use App\Services\ImageService;

class WorksController extends Controller
{
    public function index(WorksRequest $request)
    {
        $userId = auth()->id();

        $works = IndexController::userWorks($userId);
        $worker = IndexController::userWorker($userId);

        $data = $request->validated();
    
        $perPage = isset($data['perPage']) ? $data['perPage'] : 5;
        $pageNum = isset($data['pageNum']) ? $data['pageNum'] : 1;

        $userId = auth()->id();

        $works = Example_work::query()
            ->where(['user_id' => $userId ])
            ->paginate(perPage: $perPage, page: $pageNum);

        return view('profile.works.index', compact('works'));
    }

    public function edit(Example_work $work)
    {
        $this->authorize('modify', $work);

        return view('profile.works.edit', compact('work'));
    }

    public function update(WorkUpdateRequest $request, Example_work $work)
    {
        $this->authorize('modify', $work);

        $data = $request->validated();

        $data['url_files'] = $this->getNewFilesPath($request, $data);
        
        unset($data['url_files_flags'], $data['photo']);

        $res = $work->update($data);

        if ($res){
            return redirect()->route('profile.works.index')->with('success', __('Данные успешно обновлены'));
        } else {
            return view('profile.works.edit')->with('error', __('При изменении данных возникла ошибка'));
        }
    }

    public function getNewFilesPath($request, $data){

        $url_files = '';

        if (isset($data['url_files_flags'])){
            $ar_url_files = array_intersect_key($data['url_files'],$data['url_files_flags']);
            $url_files .= implode(', ', $ar_url_files);
        }

        if ($request->hasFile('photo')){
            $url_files .= $url_files ? ',' : '';
            $url_files .= ImageService::getNewPhotoPath($request, 'photo', config('filesystems.img.works'));
        }

        if ($url_files){
            $arFilesPath = explode(',', $url_files);

            if (count($arFilesPath) > ImageService::LIMIT_FILES){
                $arFilesPath = array_slice($arFilesPath, 0, 5);
                $url_files = implode(', ', $arFilesPath);
            }
        }

        return $url_files;
    }

    public function delete(Example_work $work)
    {
        $this->authorize('delete', $work);

        dd($work);
        // can ?
        // work

        $userId = auth()->id();

        $works = Example_work::query()
            ->where(['user_id' => $userId ]);

        return view('profile.works.index', compact('work'));
    }
}
