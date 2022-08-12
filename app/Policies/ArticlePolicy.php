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
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param ?User $user
     * @param Article $article
     * @return bool
     */
    public function view(?User $user, Article $article): bool
    {
        return $article->isAvailable() or $user->is_admin or $user->id === $article->author->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->author->id or $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->author->id or $user->is_admin;
    }

    /**
     * Determine whether the user can view unchecked articles.
     *
     * @param User $user
     * @return bool
     */
    public function viewUnchecked(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can check the article.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function check(User $user, Article $article): bool
    {
        return $user->is_admin and $article->type->is(ArticleType::OnCheck());
    }

    /**
     * Determine whether the user can like the article.
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function like(User $user, Article $article): bool
    {
        return $article->type->is(ArticleType::Checked);
    }

    /**
     * Determine whether the user can view unpublished articles.
     *
     * @param User $user
     * @return bool
     */
    public function viewUnpublished(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view drafts.
     *
     * @param User $user
     * @return bool
     */
    public function viewDrafts(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can save article to drafts.
     *
     * @param User $user
     * @param ?Article $article
     * @return bool
     */
    public function saveToDrafts(User $user, ?Article $article = null): bool
    {
        if ($article && $article->type->is(ArticleType::Checked)) {
            return false;
        }

        return $user->articles()->count() < Article::MAX_DRAFTS_COUNT;
    }
}
