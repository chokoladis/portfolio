<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Workers;
use App\Models\Example_work;
use App\Http\Controllers\HelperController as Helpers;

class ProfileController extends Controller
{
    public static $defaultFolderImg = '/storage/workers/img/';

    public function index()
    {
        if (auth()->user() === null) return false;

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

    public static function changeAvatar(Request $request){
    
        if (auth()->user() === null) return false;

        $success = false;
    
        $userId = auth()->user()->id;

        if ($request->hasFile('user_avatar')) {

            $photo = $request->file('user_avatar');
            $photoExt = $photo->extension();
            
            if (Helpers::$acceptFileSize < $photo->size){
                return Helpers::jsonRespose(
                    [
                        'success' => false,
                        'response' => 'Файл превышает 3МБ'
                    ]);
            }
            
            $photoNewName = Hash::make('user_'.$userId.'_avatar', ['rounds' => 5]);

            $photo_path = self::$defaultFolderImg.$photoNewName.'.'.$photoExt;
            if (!file_exists(public_path() . $photo_path)){
                $photo->move(public_path() . self::$defaultFolderImg, $photoNewName.'.'.$photoExt);
            }

            $data['url_avatar'] = $photo_path;

            $workerQuery = Workers::query()
                ->where('user_id', '=', $userId)
                ->where('url_avatar', '<>', null)
                ->select('url_avatar')
                ->first();

            $data['old_url_avatar'] = $workerQuery->url_avatar;
        }

        if(isset($data['url_avatar'])){

            if (isset($data['old_url_avatar'])){
                // delete 
            }

            // set img for profile-workers

            $success = true;
            $response = [ 'result' => 'Аватар успешно изменен' ];
        } else {
            $response = [ 'error' => 'Не удалось задать новую аватарку' ];
        }

        $res = [
            'success' => $success,
            'response' => $response
        ];

        Helpers::jsonRespose($res);
    }
    
}
