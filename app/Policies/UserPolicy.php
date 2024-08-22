<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workers;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function viewUser(User $user, User $model): bool
    {
        return $model->role == 'user';
    }

    public function viewAdmin(User $user, User $model): bool
    {
        return $model->role == 'admin';
    }

    public function auth(User $user, User $model): bool
    {
        dd($model);
        // return $model;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }

    public function modify(User $user, User $model): bool
    {
        return $model->id === $user->id || $user->role === 'admin';
    }
}
