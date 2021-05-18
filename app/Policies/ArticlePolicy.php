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
        return $article->isAvailable() or $user->is_admin or $user->id === $article->author->id;
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
     * Determine whether the user can view unchecked articles.
     *
     * @param User $user
     * @return mixed
     */
    public function viewUnchecked(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can check the article.
     *
     * @param User $user
     * @param Article $article
     * @return mixed
     */
    public function check(User $user, Article $article)
    {
        return $user->is_admin and $article->type->is(ArticleType::OnCheck());
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
        return $article->type->is(ArticleType::Checked());
    }
}
