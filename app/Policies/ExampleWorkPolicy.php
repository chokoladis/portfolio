<?php

namespace App\Policies;

use App\Models\Example_work;
use App\Models\User;

class ExampleWorkPolicy
{
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

    public function recycle(User $user): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Example_work $work): bool
    {
        //
    }
}
