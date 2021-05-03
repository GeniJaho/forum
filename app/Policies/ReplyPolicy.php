<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    public function create(User $user): bool
    {
        if (!$lastReply = $user->fresh()->lastReply) {
            return true;
        }

        return !$lastReply->wasJustPublished();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Reply $reply
     * @return mixed
     */
    public function delete(User $user, Reply $reply)
    {
        return $this->update($user, $reply);
    }
}
