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
        $userId = auth()->user()->id;

        $works = IndexController::userWorks($userId);
        $worker = IndexController::userWorker($userId);

        $data = $request->validated();
    
        $perPage = isset($data['perPage']) ? $data['perPage'] : 5;
        $pageNum = isset($data['pageNum']) ? $data['pageNum'] : 1;

        $userId = auth()->user()->id;

        $works = Example_work::query()
            ->where(['user_id' => $userId ])
            ->paginate(perPage: $perPage, page: $pageNum);

        return view('profile.works.index', compact('works'));
    }

    public function edit(Example_work $work)
    {
        $this->authorize('edit', $work);

        return view('profile.works.edit', compact('work'));
    }

    public function update(WorkUpdateRequest $request, Example_work $work)
    {
        $data = $request->validated();

        $arModiferUrlFiles = array_intersect_key($data['url_files'],$data['url_files_flags']);
        $data['url_files'] = implode(', ', $arModiferUrlFiles);

        unset($data['url_files_flags'], $data['photo']);

        if ($request->hasFile('photo')){
            $photo = $request->file('photo');

            $url_files = ImageService::getNewPhotoPath($request, 'photo', config('filesystems.img.works'));

            $url_files = $data['url_files'].', '.$url_files;

            $data['url_files'] = $url_files;
        }

        $success = Example_work::find($work->id)->update($data);
    
        $perPage = isset($data['perPage']) ? $data['perPage'] : 5;
        $pageNum = isset($data['pageNum']) ? $data['pageNum'] : 1;

        $userId = auth()->user()->id;

        $works = Example_work::query()
            ->where(['user_id' => $userId ])
            ->paginate(perPage: $perPage, page: $pageNum);

        return view('profile.works.index', compact('works'));
    }

    public function delete(Example_work $work)
    {
        dd($work);
        // can ?
        // work

        $userId = auth()->user()->id;

        $works = Example_work::query()
            ->where(['user_id' => $userId ]);

        return view('profile.works.index', compact('work'));
    }
}
