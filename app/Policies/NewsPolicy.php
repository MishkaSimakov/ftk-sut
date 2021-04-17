<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any news.
     *
     * @param ?User $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create news.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param User $user
     * @param News $news
     * @return bool
     */
    public function update(User $user, News $news)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param User $user
     * @param News $news
     * @return bool
     */
    public function delete(User $user, News $news)
    {
        return $user->is_admin;
    }
}
