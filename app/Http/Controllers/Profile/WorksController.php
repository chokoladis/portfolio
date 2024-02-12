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

    public function update(WorkUpdateRequest $request)
    {
        if ($request->hasFile('photo')){
            $ar = ImageService::getNewPhotoPath($request, 'photo', config('filesystems.img.works'));
            dump($ar);
        }
        dd($request->all());
        $data = $request->validated();
    
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
