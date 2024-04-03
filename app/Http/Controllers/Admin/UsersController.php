<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use App\Models\Workers;
use App\Http\Requests\Users\FilterRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Controllers\HelperController;
use Illuminate\Support\Str;

class UsersController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $query = User::query();

        $query = isset($data['profile']) ? $this->filterByProfile($query, $data['profile']) : $query;
        $query = HelperController::filterByCreatedAt($query, $data);

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        $users = $query->paginate($perPage)->appends(request()->query());
        
        return view('admin.users.index', compact('users'));
    }

    public function filterByProfile($query, $fieldProfile){

        return $query
            ->where('name', 'like', '%'.$fieldProfile.'%')
            ->get();
    }

    public function edit(User $user)
    {
        // $this->authorize('modify', $user);

        // Event(new ViewsAdminEvent($worker));
 
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        dump($request);
        dd($user);
        // Hash::make('password')
        // if (error){
        //     return view('admin.user.edit', compact('worker','works'));
        // } else {

        // }
    }
}
