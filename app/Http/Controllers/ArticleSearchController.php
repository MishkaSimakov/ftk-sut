<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Scoping\Scopes\Articles\AuthorScope;
use App\Scoping\Scopes\Articles\QueryScope;
use App\Scoping\Scopes\Articles\TagScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ArticleSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $articles = Article::published()->checked()
            ->withScopes($this->scopes())
            ->latest('date')
            ->get();

        if ($request->wantsJson()) {
            return $this->makeJsonResponse($articles);
        }

        $articles->load(['author', 'points']);

        $query = $this->getQueryString($request);

        return view('articles.search', compact('articles', 'query'));
    }

    protected function scopes(): array
    {
        return [
            'query' => new QueryScope(),
            'tag' => new TagScope(),
            'author' => new AuthorScope()
        ];
    }

    protected function makeJsonResponse(Collection $articles): JsonResponse
    {
        return response()->json(
            $articles->take(5)->map->only(['title', 'url'])
        );
    }

    protected function getQueryString(Request $request): string
    {
        $query = 'Статьи';

        if ($request->has('author')) {
            $query .= ' пользователя ' . $request->get('author');
        }

        if ($request->has('tag')) {
            $query .= ' с тегом ' . $request->get('tag');
        }

        if ($request->has('query')) {
            $query .= " по запросу «{$request->get('query')}»";
        }

        return $query;
    }
}
