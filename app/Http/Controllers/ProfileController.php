<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Workers;
use App\Models\Example_work;

class ProfileController extends Controller
{
    public function index()
    {
        if (auth()->user() === null) return false;

        $userId = auth()->user()->id;

        $works = $this->userWorks($userId);
        $worker = $this->userWorker($userId);

        return view('profile.index', compact('worker', 'works'));
    }

    private function userWorks(int $userId){
        $perPage = 5;
        $query = Example_work::query()->where('user_id', $userId);
        return $query->paginate($perPage);
    }

    private function userWorker(int $userId){
        return DB::table('workers')
                ->join('users', 'workers.user_id', '=', 'users.id')
                ->select('users.name', 'workers.*')
                ->where('workers.user_id', '=', $userId);
    }
}
