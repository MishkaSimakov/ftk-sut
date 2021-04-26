<?php

namespace App\Http\Controllers;

use App\Enums\ArticleType;
use App\Events\Article\ArticlePublished;
use App\Http\Requests\Articles\StoreArticleRequest;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Services\ArticleBodyPrepareService;
use App\Services\ArticleSearchService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public ArticleBodyPrepareService $articleBodyPrepareService;
    public ArticleSearchService $articleSearchService;

    public function __construct(ArticleSearchService $articleSearchService, ArticleBodyPrepareService $articleBodyPrepareService)
    {
        $this->articleSearchService = $articleSearchService;
        $this->articleBodyPrepareService = $articleBodyPrepareService;

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
        $article = new Article;

        $article->title = $request->get('title');

        $article->author()->associate($request->user());

        $article->date = $request->get('delayed_publication') == 'on' ? $request->get('date') : now();
        $article->type = $request->user()->is_admin ? ArticleType::Published() : ArticleType::OnCheck();

        $article->save();

        $article->update([
            'body' => $this->articleBodyPrepareService->getPreparedBody(
                $request->get('body'), $article
            )
        ]);

        if ($tags = $request->get('tags')) {
            foreach (json_decode($tags) as $tag) {
                $tag_id = ArticleTag::firstOrCreate(['name' => $tag->value]);

                $article->tags()->syncWithoutDetaching($tag_id);
            }
        }



        return redirect()->route('article.index');
    }

    public function show(Article $article)
    {
        if ($article->type == ArticleType::Published()) {
            views($article)->cooldown(now()->addDay())->record();
        }

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(StoreArticleRequest $request, Article $article)
    {
        $article->title = $request->get('title');

        $this->articleBodyPrepareService->deleteSavedImages($article);
        $article->body = $this->articleBodyPrepareService->getPreparedBody($request->get('body'), $article);

        if ($article->isNotPublished) {
            $article->date = $request->get('delayed_publication') == 'on' ? $request->get('date') : now();
        }
        $article->type = $request->user()->is_admin ? ArticleType::Published() : ArticleType::OnCheck();

        $article->save();

        return redirect()->route('article.show', $article);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.index');
    }

    public function unpublished()
    {
        $this->authorize('viewUnpublished', Article::class);

        $articles = Article::where('type', ArticleType::OnCheck())->orderBy('date', 'desc')->get();

        return view('articles.unpublished', compact('articles'));
    }

    public function publish(Article $article)
    {
        $this->authorize('publish', $article);

        $article->type = ArticleType::Published();
        $article->save();

        return redirect()->route('article.show', $article);
    }
}
