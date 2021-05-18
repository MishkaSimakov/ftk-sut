<?php

namespace App\Http\Controllers;

use App\Enums\ArticleType;
use App\Http\Requests\Articles\StoreArticleRequest;
use App\Http\Resources\Article\ArticleTagIndexResource;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Services\ArticleSearchService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public ArticleSearchService $articleSearchService;

    public function __construct(ArticleSearchService $articleSearchService)
    {
        $this->articleSearchService = $articleSearchService;

        $this->authorizeResource(Article::class, 'article');
    }

    public function index(Request $request)
    {
        if ($request->has('query')) {
            $results = $this->articleSearchService->getQueryResults($request->get('query'), false);

            return view('articles.search', array_merge($results, [
                'query' => $request->get('query')
            ]));
        }

        return view('articles.index');
    }

    public function create()
    {
        $tags = ArticleTag::select(['name'])->get();

        return view('articles.create', compact('tags'));
    }

    public function store(StoreArticleRequest $request)
    {
        $article = new Article([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'date' => $request->get('delayed_publication') == 'on' ? $request->get('date') : now(),
            'author_id' => $request->user()->id
        ]);

        $article->save();

        $article->attachTagsFromString($request->get('tags'));

        if ($request->user()->is_admin) {
            $article->check();
        }

        return redirect()->route('article.index');
    }

    public function show(Article $article)
    {
        if ($article->type->is(ArticleType::Checked())) {
            views($article)->cooldown(now()->addDay())->record();
        }

        $article->load(['author', 'tags', 'points']);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $tags = ArticleTag::select(['name'])->get();

        return view('articles.edit', compact('article', 'tags'));
    }

    public function update(StoreArticleRequest $request, Article $article)
    {
        $article->body = $request->get('body');
        $article->title = $request->get('title');

        if (!$request->user()->is_admin) {
            $article->type = ArticleType::OnCheck();
        }

        $article->date = $request->get('delayed_publication') == 'on' ? $request->get('date') : now();

        $article->save();

        $article->tags()->delete();
        $article->attachTagsFromString($request->get('tags'));

        return redirect()->route('article.show', $article);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.index');
    }

    public function unchecked()
    {
        $this->authorize('viewUnchecked', Article::class);

        if (auth()->user()->is_admin) {
            $articles = Article::where('type', ArticleType::OnCheck())->orderBy('date', 'desc')->get();
        } else {
            $articles = auth()->user()->articles()->where('type', ArticleType::OnCheck())->orderBy('date', 'desc')->get();
        }

        return view('articles.unchecked', compact('articles'));
    }

    public function check(Article $article)
    {
        $this->authorize('check', $article);

        $article->check();

        return redirect()->route('article.show', $article);
    }
}
