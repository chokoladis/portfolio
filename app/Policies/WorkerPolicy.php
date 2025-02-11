<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workers;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class WorkerPolicy
{
    public function view(User $user){
        $currentUser = $user->id && $user->email_verified_at;
        $admin = $user->role == 'admin';
        return $currentUser || $admin;
    }

    public function store(User $user): bool
    {
        $currentUser = $user->id && $user->email_verified_at;
        $admin = $user->role == 'admin';
        return $currentUser || $admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function modify(User $user, Workers $workers): bool
    {
        $currentUser = $workers->user->id === $user->id;
        $admin = $user->role == 'admin';
        return $currentUser || $admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Workers $workers): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Workers $workers): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Workers $workers): bool
    {
        //
    }
}
