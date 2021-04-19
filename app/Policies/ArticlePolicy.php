<?php

namespace App\Policies;

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param ?User $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param ?User $user
     * @param Article $article
     * @return mixed
     */
    public function view(?User $user, Article $article)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Article $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->author->id or $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Article $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->author->id or $user->is_admin;
    }

    /**
     * Determine whether the user can view unpublished articles.
     *
     * @param User $user
     * @return mixed
     */
    public function viewUnpublished(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can publish the article.
     *
     * @param User $user
     * @param Article $article
     * @return mixed
     */
    public function publish(User $user, Article $article)
    {
        return $user->is_admin and $article->type === ArticleType::OnCheck();
    }

    /**
     * Determine whether the user can like the article.
     *
     * @param User $user
     * @param Article $article
     * @return mixed
     */
    public function like(User $user, Article $article)
    {
        return $article->type == ArticleType::Published();
    }
}
