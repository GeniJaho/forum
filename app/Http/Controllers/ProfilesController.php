<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->getActivity($user)
        ]);
    }

    /**
     * @param User $user
     * @return Collection
     */
    protected function getActivity(User $user): Collection
    {
        return Activity::feed($user)->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
