<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreRequest;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // show all feedback in admin
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // header();
        dd(1);

        $data = $request->validated();

        $clientIP = $request->ip();

        $data['ip_address'] = $clientIP;

        $feedback = Feedback::find([ 'ip_address' => $clientIP ])->get(['created_at']);

        if (!empty($feedback)){

            $now = Carbon::now();
            $feedback_create = Carbon::parse($feedback['created_at']);

            $hours = $now->diffInHours($feedback_create);

            dd($hours);
        }

        $res = Feedback::query()->create($data);

        if ($res){
            self::$response = __('Завяка отправлена');
        } else {
            self::$success = false;
            self::$error = __('Не удалось отправить заявку');
        }

        dd($res);

        return responseJson(self::$success, self::$response, self::$error);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
