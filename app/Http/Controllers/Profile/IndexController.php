<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Workers;
use App\Models\Example_work;
use App\Services\ImageService;
// use App\Http\Controllers\HelperController as Helper;
use App\Http\Requests\Profile\UpdateImgRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Controllers\WorkersController;
use App\Http\Requests\Profile\ChangeUserInfoRequest;
use App\Http\Requests\Profile\WorksRequest;
use App\Services\FileService;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';

    public function index()
    {
        $userId = auth()->id();

        $works = $this->userWorks($userId);
        $worker = $this->userWorker($userId);

        $isEmptyProfile = !$worker ? true : false;

        return view('profile.index', compact('worker', 'works', 'isEmptyProfile'));
    }

    public static function userWorks(int $userId){
        $perPage = 5;
        $query = Example_work::query()->where('user_id', $userId);
        return $query->paginate($perPage);
    }

    public static function userWorker(int $userId){
        return DB::table('workers')
                ->join('users', 'workers.user_id', '=', 'users.id')
                ->select('users.fio', 'workers.*')
                ->where('workers.user_id', '=', $userId)->first();
    }

    public static function changeAvatar(UpdateImgRequest $request){
    
        $userId = auth()->id();

        $fileService = new FileService($request, 'url_avatar', 'Workers');
        $arResFiles = $fileService->handlerFiles();
        $file_path = '';

        if (!empty($arResFiles['file_saved'])){
            $file_path = $arResFiles['file_saved'][0]['path'];
        }

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
            if (!empty($arResFiles['errors'])){
                self::$error = __('Не удалось задать новую аватарку - '.$arResFiles['errors'][0]);
            } else {
                self::$error = __('Не удалось задать новую аватарку');
            }
        }

        return responseJson(self::$success, self::$response, self::$error);
    }

    public function update(UpdateRequest $request){
        
        $data = $request->validated(); 

        $data['socials'] = WorkersController::getSocials($data['socials']);
        $phone = WorkersController::getNumbers($data['phone']);
        $data['phone'] = !empty($phone) ? implode('', $phone) : null;

        $userId = auth()->id();
        
        $worker = Workers::query()
            ->where(['user_id' => $userId]);

        $user = User::query()
            ->where(['id' => $userId]);

        if ($worker->update($data) ){
            // && $user->update(['name' => $data['name']])){ todo
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

    public function changeUserInfo(ChangeUserInfoRequest $request){

        $data = $request->validated();
        
        if (isset($data['password']) && $data['password']){
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = User::query()->where('id', auth()->id())->first();
        $user->update($data);

        return redirect()->route('profile.index');
    }
}
