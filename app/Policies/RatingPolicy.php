<?php

namespace App\Policies;

use App\Models\RatingPoint;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create rating points.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the rating point.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->is_admin;
    }


}
