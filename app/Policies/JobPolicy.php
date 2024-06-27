<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\UserJob;
use App\Models\User;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserJob $userJob): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserJob $userJob): bool
    {
        return $user->id === $userJob->user_id ? Response::allow()
        : Response::deny('You do not own this job.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserJob $userJob): bool
    {
        return $user->id === $userJob->user_id ? Response::allow()
        : Response::deny('You do not own this job.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserJob $userJob): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserJob $userJob): bool
    {
        //
    }
}
