<?php

namespace App\Http\Controllers;

use App\Enums\ArticleType;
use App\Http\Requests\Articles\StoreArticleRequest;
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

            return view('articles.search', [
                'articles' => $results['articles'],
                'users' => $results['users'],
                'tags' => $results['tags'],
                'query' => $request->get('query')
            ]);
        }

        return view('articles.index');
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $article = new Article([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'date' => $request->get('delayed_publication') == 'on' ? $request->get('date') : now()
        ]);

        $article->author()->associate($request->user());
        $article->save();

        if ($tags = $request->get('tags')) {
            foreach (json_decode($tags) as $tag) {
                $tag_id = ArticleTag::firstOrCreate(['name' => $tag->value]);

                $article->tags()->syncWithoutDetaching($tag_id);
            }
        }

        if ($request->user()->is_admin) {
            $article->check();
        }

        return redirect()->route('article.index');
    }

    public function show(Article $article)
    {
        if ($article->type == ArticleType::Checked()) {
            views($article)->cooldown(now()->addDay())->record();
        }

        $article->load(['author', 'tags', 'points']);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(StoreArticleRequest $request, Article $article)
    {
        $article->title = $request->get('title');

        if (!$request->user()->is_admin) {
            $article->type = ArticleType::OnCheck();
        }
        if ($article->isNotPublished) {
            $article->date = $request->get('delayed_publication') == 'on' ? $request->get('date') : now();
        }

        // TODO: добавить обновление тегов

        $article->save();

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
