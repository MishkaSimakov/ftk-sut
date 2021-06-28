<?php

namespace App\Http\Controllers;

use App\Enums\ArticleType;
use App\Http\Requests\Articles\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\User;
use App\Scoping\Scopes\Articles\AuthorScope;
use App\Scoping\Scopes\Articles\QueryScope;
use App\Scoping\Scopes\Articles\TagScope;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        return view('articles.index');
    }

    public function create()
    {
        [$tags, $users] = $this->getDataForChangingArticle();

        return view('articles.create', compact('tags', 'users'));
    }

    public function store(ArticleRequest $request)
    {
        $article = Article::create([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'date' => $request->get('delayed_publication') == 'on' ? $request->get('date') : now(),
            'author_id' => $request->user()->is_admin ? $request->get('author') : $request->user()->id,
            'type' => $request->get('is_draft') == true ? ArticleType::Draft : ArticleType::OnCheck,
        ]);

        $article->attachTagsFromString($request->get('tags'));
        $article->storeImagesFromBody();

        if ($request->user()->is_admin && $article->type->isNot(ArticleType::Draft)) {
            $article->check();
        }

        return redirect()->route('articles.show', $article);
    }

    public function show(Article $article)
    {
        if ($article->type->is(ArticleType::Checked)) {
            views($article)->cooldown(now()->addDay())->record();
        }

        $article->load(['author', 'tags', 'points']);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        [$tags, $users] = $this->getDataForChangingArticle();

        return view('articles.edit', compact('article', 'tags', 'users'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'date' => $request->get('delayed_publication') == 'on' ? $request->get('date') : $article->date,
            'author_id' => $request->user()->is_admin ? $request->get('author') : $request->user()->id
        ]);

        if (!$request->user()->is_admin) {
            $article->update([
                'type' => $request->get('is_draft') == true ? ArticleType::Draft : ArticleType::OnCheck
            ]);
        } else {
            $article->check();
        }

        $article->attachTagsFromString($request->get('tags'));

        $article->storeImagesFromBody();

        return redirect()->route('articles.show', $article);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index');
    }

    public function unchecked()
    {
        $this->authorize('viewUnchecked', Article::class);

        if (auth()->user()->is_admin) {
            $articles = Article::unchecked();
        } else {
            $articles = auth()->user()->articles()->unchecked();
        }

        $articles = $articles->latest('date')->get();

        return view('articles.unchecked', compact('articles'));
    }

    public function unpublished()
    {
        $this->authorize('viewUnpublished', Article::class);

        if (auth()->user()->is_admin) {
            $articles = Article::unpublished()->latest('date')->get();
        } else {
            $articles = auth()->user()->articles()->unpublished()->latest('date')->get();
        }

        return view('articles.unpublished', compact('articles'));
    }

    public function drafts()
    {
        $this->authorize('viewDrafts', Article::class);

        $articles = auth()->user()->articles()->drafts()->latest('date')->get();

        return view('articles.drafts', compact('articles'));
    }

    public function check(Article $article)
    {
        $this->authorize('check', $article);

        $article->check();

        return redirect()->route('articles.show', $article);
    }

    public function tags()
    {
        $tags = ArticleTag::withCount('articles')->orderByDesc('articles_count')->get();

        return view('articles.tags', compact('tags'));
    }

    protected function getDataForChangingArticle(): array
    {
        $tags = ArticleTag::select(['name'])->get();
        $users = User::select(['id', 'name'])->orderBy('name')->get();

        return [$tags, $users];
    }
}
