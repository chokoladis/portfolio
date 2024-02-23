<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\FilterRequest;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    static $error = '';
    static $success = true;
    static $response = '';

    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;
        
        $query = Feedback::query();

        $feedbacks = $query->paginate($perPage)->appends(request()->query());

        return view('admin.feedback.index', compact('feedbacks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Feedback $feedback)
    {
        
    }
}
