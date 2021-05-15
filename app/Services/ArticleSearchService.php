<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ArticleSearchService
{
    public function getQueryResults(string $query, bool $wantsJson = true)
    {
        $articles = $this->getArticlesFromQuery($query);
        $tags = $this->getTagsFromQuery($query);
        $users = $this->getUsersFromQuery($query);

        if (!$wantsJson) {
            return [
                'articles' => $articles,
                'tags' => $tags,
                'users' => $users
            ];
        }

        return $articles->concat($tags)->concat($users)->map(function ($result) {
            $result->type = Str::lower(class_basename($result));

            return $result->only('id', 'name', 'type', 'url');
        });
    }

    protected
    function getArticlesFromQuery(string $query): Collection
    {
        return Article::where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->orWhereHas('tags', function (Builder $builder) use ($query) {
                return $builder->where('name', 'like', "%{$query}%");
            })->get()->map(function (Article $article) {
                $article->name = $article->title;

                return $article;
            });
    }

    protected
    function getTagsFromQuery(string $query): Collection
    {
        return ArticleTag::where('name', 'like', "%{$query}%")->get();
    }

    protected
    function getUsersFromQuery(string $query): Collection
    {
        return User::where('name', 'like', "%{$query}%")->get();
    }
}
