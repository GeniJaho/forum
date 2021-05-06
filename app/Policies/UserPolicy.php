<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $signedInUser
     * @param User $user
     * @return bool
     */
    public function update(User $signedInUser, User $user): bool
    {
        return $signedInUser->is($user);
    }
}
