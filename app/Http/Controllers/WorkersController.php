<?php

namespace App\Http\Controllers;

use App\Events\ViewsEvent;
use App\Models\User;
use App\Models\Workers;
use App\Http\Requests\Workers\StoreRequest;
use App\Http\Requests\Workers\FilterRequest;
use App\Http\Controllers\HelperController;
use App\Models\Workers_stats;
use App\Services\FileService;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class WorkersController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';

    const SOCIAL_LIST = [ // placeholder
        'telegram' => '',
        'github' => '',
        'hh' => '',
        'kwork' => ''
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        if (!Gate::allows('view', Workers::class)){
            abort(403);
        }

        $workerById = null;
        if (auth()->user()){
            $userId = auth()->id();
            $workerById = Workers::where('user_id', '=', $userId)->first();
        }

        $data = $request->validated();

        $queryWorkers = Workers::query();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        if (isset($data['profile'])){
            $queryWorkers = $this->filterByProfile($queryWorkers, $data['profile']);
        }

        $workers = $queryWorkers->paginate($perPage)->appends(request()->query());

        return view('workers.index', compact('workers', 'workerById'));
    }

    public function filterByProfile($queryWorkers, $fieldProfile){

        if ($this->isUsername($fieldProfile)){

            $arUsersId = $this->getUsersByLikeName($fieldProfile);
            $arUsersId = !empty($arUsersId) ? $arUsersId : [0];

            $queryWorkers->whereIn('user_id', $arUsersId);

        } else {

            $matches = $this->getNumbers($fieldProfile);

            if (!empty($matches)){
                $phone = implode('', $matches);
                $queryWorkers->where('phone', 'like', '%'.$phone.'%');
            }
        }

        return $queryWorkers;
    }

    public static function isUsername(string $data) : bool {

        preg_match('/[a-zA-Z]+/', $data, $matches_letter);
        return !empty($matches_letter) ? true : false;
    }

    public static function getNumbers(string $data) : array {

        preg_match_all('/[\d]/', $data, $matches_num);
        if(!empty($matches_num)){
            // && count($matches_num[0]) > 3){
            return $matches_num[0];
        } else {
            return [];
        }
    }

    public static function getUsersByLikeName(string $name) : array{

        $userFinder = User::query()
            ->where('name', 'like', '%'.$name.'%')
            ->get();

        $arUsersId = [];

        foreach($userFinder as $user){
            if ($user->role !== 'admin'){
                $arUsersId[] = $user->id;
            }
        }

        return $arUsersId;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if (!Gate::allows('store', Workers::class)){
            abort(403);
        }

        $data = $request->validated();

        $data['socials'] = isset($data['socials']) ? $this->getSocials($data['socials']) : null;
        $phone = $this->getNumbers($data['phone']);
        $data['phone'] = !empty($phone) ? implode('', $phone) : null;

        $fileService = new FileService($request, 'photo', 'Workers');
        $arResFiles = $fileService->handlerFiles();

        if (!empty($arResFiles['file_saved'])){
            $filePath = $arResFiles['file_saved'][0]['path'];
        } elseif(!empty($arResFiles['errors'])) {
            $error = $arResFiles['errors'][0];
        } else {
            $error = 'Не предвиденная ошибка';
        }

        $data['url_avatar'] = $filePath ?? null;

        unset($data['photo']);

        $data['code'] = translateToCode(User::find(auth()->user()->id, 'fio'));

        $res = Workers::firstOrCreate(
            [ 'user_id' => auth()->user()->id ],
            $data
        );

        if ($res->wasRecentlyCreated){
            self::$response = __('Профиль Workers создан');
            if (isset($error) && $error){
                self::$error = __('Аватарку не удалось сохранить - '. $error);
            }
        } else {
            self::$success = false;
            self::$error = __('Профиль Workers с такими данными уже есть в БД');
        }

        return responseJson(self::$success, self::$response, self::$error);
    }

    public static function getSocials(array|null $data){

        if ($data === null)
            return $data;

        if (isset($data['telegram']))
            $data['telegram'] = HelperController::replaceArrobaToLink($data['telegram'], 't.me');

        if(isset($data['github']))
            $data['github'] = HelperController::replaceArrobaToLink($data['github'], 'github.com');

        return json_encode($data);
    }

    public function detail(Workers $worker)
    {
        if (!Gate::allows('view', Workers::class)){
            abort(403);
        }

        Event(New ViewsEvent($worker));

        $works = $worker->getWorks();

        $worker = [
            'id' => $worker->id,
            'code' => $worker->code,
            'fio' => $worker->user->fio,
            'url_avatar' => $worker->url_avatar,
            'phone' => $worker->phone,
            'about' => $worker->about,
            'socials' => $worker->socials,

        ];

        return view('workers.detail', compact('worker','works'));
    }
}
