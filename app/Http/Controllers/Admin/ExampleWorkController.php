<?php

namespace App\Http\Controllers\Admin;

use App\Events\ViewsAdminEvent;
use App\Http\Requests\ExampleWork\UpdateRequest;
use App\Http\Requests\ExampleWork\FilterRequest;
use App\Models\Example_work;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Services\ImageService;
use Illuminate\Auth\Middleware\Authorize;

class ExampleWorkController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';


    public function index(FilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;
        
        $query = Example_work::query();
        if (isset($data['show_deleted']) && $data['show_deleted'])
            $query = $query->withTrashed();
        
        $query = isset($data['work']) ? $this->filterByWork($query, $data['work']) : $query;
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;
        $query = HelperController::filterByCreatedAt($query, $data);

        $works = $query->paginate($perPage)->appends(request()->query());

        return view('admin.works.index', compact('works'));
    }

    public function detail(Example_work $work){
        return view('works.detail', compact('work'));
    }

    public function filterByWork($query, $data){
        return $query->where('title', 'like', '%'.$data.'%')
                ->orWhere('description', 'like', '%'.$data.'%')
                ->orWhere('url_work', 'like', '%'.$data.'%')
                ->orWhere('slug', 'like', '%'.$data.'%');
    }

    public function filterByProfile($query, $data){

        $arUsersId = $this->getUsersByLikeName($data);
        $arUsersId = !empty($arUsersId) ? $arUsersId : [0];

        return $query->whereIn('user_id', $arUsersId);
    }

    public function getUsersByLikeName(string $data) : array{

        $userFinder = User::query()
            ->where('name', 'like', '%'.$data.'%')
            ->orWhere('email', 'like', '%'.$data.'%')
            ->get();

        $arUsersId = [];

        foreach($userFinder as $user){
            if ($user->role !== 'admin'){
                $arUsersId[] = $user->id;
            }
        }

        return $arUsersId;
    }

    public function edit(Example_work $work){
        
        $this->authorize('modify', $work);

        Event(new ViewsAdminEvent($work));

        return view('admin.works.edit', compact('work'));
    }

    public function update(UpdateRequest $request, Example_work $work){
        
        $this->authorize('modify', $work);

        $data = $request->validated(); 

        $data['url_files'] = $this->getNewFilesPath($request, $data);
        
        unset($data['url_files_flags'], $data['photo']);

        $res = $work->update($data);

        if ($res){
            return redirect()->route('admin.works.index')->with('success', __('Данные успешно обновлены'));
        } else {
            return redirect()->route('admin.menu.edit')->with('error', __('При изменении данных возникла ошибка'));
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

    public function delete(Example_work $work){

        $this->authorize('delete', $work);
        
        if ($work->delete()){
            return responseJson(true, __('Запись помечена на удаление'));
        } else {
            return responseJson(false, '', __('Произошла ошибка при удалении'));
        }
    }

    public function forceDelete($slug){

        $work = Example_work::query()->where('slug', $slug)->withTrashed()->first();

        $this->authorize('delete', $work);
        
        if ($work->forceDelete()){
            return responseJson(true, __('Запись успешно удалена'));
        } else {
            return responseJson(false, '', __('Произошла ошибка при удалении'));
        }
    }
    

    public function restore($slug){

        $work = Example_work::query()->where('slug', $slug)->withTrashed()->restore();
        if ($work){
            return redirect()->route('admin.works.index');
        }
        
    }

    public static function notViewedAdmin(){

        // use cache
        $count = Example_work::where("deleted_at", null)
            ->join('example_works_stats', 'example_works.id', '=', 'example_works_stats.work_id')
            ->where('example_works_stats.viewed_admin_at', null)
            ->count();

        return $count;
    }


    public function recycle(FilterRequest $request){

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;
        
        $query = Example_work::query()->onlyTrashed();
        
        $query = isset($data['work']) ? $this->filterByWork($query, $data['work']) : $query;
        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;
        $query = HelperController::filterByCreatedAt($query, $data);

        $works = $query->paginate($perPage)->appends(request()->query());

        return view('admin.works.recycle', compact('works'));
    }

    public function recycleDelete(){

        $this->authorize('recycle');

        $data = request()->validate([
            'works' => 'required|array',
            'works.*' => 'numeric'
        ]);
        $worksId = $data['works'];

        $works = Example_work::query()->withTrashed()->where('id', $worksId)->get();

        $res = $works->destroy();
        dump($works,$res);
        return view('admin.works.recycle', compact('works'));
    }

}
