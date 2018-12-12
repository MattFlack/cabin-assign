<?php

namespace App\Policies;

use App\User;
use App\Camp;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the camp.
     *
     * @param  \App\User  $user
     * @param  \App\Camp  $camp
     * @return mixed
     */
    public function update(User $user, Camp $camp)
    {
        return $camp->user_id == $user->id;
    }
}
