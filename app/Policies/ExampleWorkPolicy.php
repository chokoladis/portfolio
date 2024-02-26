<?php

namespace App\Policies;

use App\Models\Example_work;
use App\Models\User;

class ExampleWorkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Example_work $work): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    public function modify(User $user, Example_work $work): bool
    {
        $currentUser = $work->user->id === $user->id;
        $admin = $user->role == 'admin';
        return $currentUser || $admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Example_work $work): bool
    {
        $currentUser = $work->user->id === $user->id;
        $admin = $user->role == 'admin';
        return $currentUser || $admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Example_work $work): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Example_work $work): bool
    {
        //
    }
}
