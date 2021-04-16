<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Thread $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Thread $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        return $this->update($user, $thread);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Thread $thread
     * @return mixed
     */
    public function restore(User $user, Thread $thread)
    {
        return $this->update($user, $thread);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Thread $thread
     * @return mixed
     */
    public function forceDelete(User $user, Thread $thread)
    {
        return $this->update($user, $thread);
    }
}
