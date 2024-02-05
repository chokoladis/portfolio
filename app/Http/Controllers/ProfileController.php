<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Workers;
use App\Models\Example_work;
use App\Http\Controllers\HelperController as Helper;
use App\Http\Requests\Profile\UpdateImgRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Controllers\WorkersController;
use App\Http\Requests\Profile\WorksRequest;


class ProfileController extends Controller
{
    public static $defaultFolderImg = '/storage/workers/img/';
    static $error = '';
    static $success = true;
    static $response = '';

    public function index()
    {
        $userId = auth()->user()->id;

        $works = $this->userWorks($userId);
        $worker = $this->userWorker($userId);

        if (!$worker){
            session([
                'status' => __('warning'),
                'msg' => __('Профиль не найден, вы можете создать его на текущей странице.')
            ]);

            return redirect()->route('workers.index');
        }

        return view('profile.index', compact('worker', 'works'));
    }

    public static function userWorks(int $userId){
        $perPage = 5;
        $query = Example_work::query()->where('user_id', $userId);
        return $query->paginate($perPage);
    }

    public static function userWorker(int $userId){
        return DB::table('workers')
                ->join('users', 'workers.user_id', '=', 'users.id')
                ->select('users.name', 'workers.*')
                ->where('workers.user_id', '=', $userId)->first();
    }

    public static function changeAvatar(UpdateImgRequest $request){
    
        $userId = auth()->user()->id;

        $helper = new Helper;
        $file_path = $helper->getNewPhotoPath($request, 'url_avatar', self::$defaultFolderImg);

        if ($file_path) {

            $workerFind = Workers::query()
                ->where('user_id', '=', $userId)
                ->first();

            $workerFind->url_avatar = $file_path;

            $res = $workerFind->save();
            if ($res){
                self::$response = __('Аватар успешно изменен');
            } else {
                self::$success = false;
                self::$error = __('Не удалось изменить аватарку');
            }
            
        } else {
            self::$success = false;
            self::$error = __('Не удалось задать новую аватарку');
        }

        return responseJson(self::$success, self::$response, self::$error);
    }

    public function update(UpdateRequest $request){
        
        $data = $request->validated(); 

        $workerController = new WorkersController();

        $data['socials'] = $workerController->getSocials($data['socials']);
        $phone = $workerController->getNumbers($data['phone']);
        $data['phone'] = !empty($phone) ? implode('', $phone) : null;

        $userId = auth()->user()->id;
        
        $worker = Workers::query()
            ->where(['user_id' => $userId]);

        $user = User::query()
            ->where(['id' => $userId]);

        if ($worker->update($data) ){
            // && $user->update(['name' => $data['name']])){
            return responseJson(true, 'success');
        } else {
            return responseJson(false, '', 'ошибка');
        }
    }
    
    public function delete(){

        $worker = $this->userWorker(auth()->user()->id);
        if (Workers::destroy($worker->id)){
            return responseJson(true, __('Профиль успешно удален'));
        } else {
            return responseJson(false, '', __('Произошла ошибка при удалении'));
        }

    }

    public function works(WorksRequest $request){
        
        $data = $request->validated();

        $perPage = isset($data['perPage']) ? $data['perPage'] : 5;
        $pageNum = isset($data['pageNum']) ? $data['pageNum'] : 1;

        $userId = auth()->user()->id;

        $works = Example_work::query()
            ->where(['user_id' => $userId ])
            ->paginate(perPage: $perPage, page: $pageNum);

        return view('profile.works.index', compact('works'));
    }
}
