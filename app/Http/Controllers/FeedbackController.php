<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreRequest;
use App\Models\Feedback;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $clientIP = $request->ip();

        $data['ip_address'] = $clientIP;

        $feedback = Feedback::query()
            ->where([ 'ip_address' => $clientIP ])
            ->latest()->first('created_at');

        if (!empty($feedback)){

            $now = Carbon::now();
            $feedback_create = Carbon::parse($feedback['created_at']);

            $diff_hours = $now->diffInHours($feedback_create);

            if ($diff_hours < 24){
                self::$success = false;
                self::$error = __('Недавно вы уже отправляли заявку, попробуйте позже');
            }
        }

        if (self::$success !== false){
            $res = Feedback::query()->create($data);

            if ($res){
                self::$response = __('Завяка отправлена');
            } else {
                self::$success = false;
                self::$error = __('Не удалось отправить заявку');
            }   
        }

        return responseJson(self::$success, self::$response, self::$error);
    }
}
