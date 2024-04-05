<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\FilterRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

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
        $arErrors = [];
        $data = $request->validated(); 

        if ($data['email'] !== $user->email
            && $countThisEmail = User::query()->where('email', $data['email'])->count()){

            $arErrors['email'] = __('Пользователь с данным email уже зарегестрирован');
        }

        if (!password_verify($data['password'], $user->password)){
            $data['password'] = Hash::make($data['password']);
        }
        
        if (!empty($arErrors)){
            return redirect()->route('admin.users.edit', $user)->with('arErrors', $arErrors);
        } else {
            
            $user->setRawAttributes($data);
            $user->save();

            return redirect()->route('admin.users.index');
        }
    }

    public function store(StoreRequest $request){

        $data = $request->validate();

        return User::create(
            array_merge(
                $data, ['password' => Hash::make($data['password'])]
            )
        );
    }
}
