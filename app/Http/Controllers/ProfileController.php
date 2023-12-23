<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Workers;
use App\Models\Example_work;
use App\Http\Controllers\HelperController as Helpers;
use App\Http\Requests\Profile\UpdateImgRequest;

class ProfileController extends Controller
{
    public static $defaultFolderImg = '/storage/workers/img/';

    public function index()
    {
        $userId = auth()->user()->id;

        $works = $this->userWorks($userId);
        $worker = $this->userWorker($userId);

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

        $helper = new HelperController;
        $file_path = $helper->getNewPhotoPath($request, 'url_avatar', self::$defaultFolderImg);

        if ($file_path) {

            $workerFind = Workers::query()
                ->where('user_id', '=', $userId)
                ->first();

            $workerFind->url_avatar = $file_path;

            $res = $workerFind->save();
            $res = $res ? [ 'success' => true, 'res' => 'Аватар успешно изменен' ]
                : [ 'success' => false, 'res' => ['error' => 'Не удалось изменить аватарку'] ];
            
        } else {
            $res = [
                'success' => false,
                'res' => [
                    'error' => 'Не удалось задать новую аватарку'
                ]
            ];
        }

        return Helpers::jsonRespose($res['success'], $res['res']);
    }

    public function update(){
        
    }
    
    public function delete(Workers $worker){
        dd($worker);
    }
}
