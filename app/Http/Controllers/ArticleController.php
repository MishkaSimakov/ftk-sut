<?php

namespace App\Http\Controllers;

use App\Achievements\Events\UserWriteArticle;
use App\Http\Requests\StoreArticle;
use App\User;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filter == 'newest') {
            $articles = Article::where('is_published', true)->latest();
        } else {
            $articles = Article::where('is_published', true)->orderBy('points', 'desc');
        }

        $articles = $articles->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        $notPublishedCount = Article::notPublished()->count();

        return view('articles.show', compact('article', 'notPublishedCount'));
    }

    public function create()
    {
        Article::where('is_blank', true)->delete();

        $article = new Article;

        $article->is_blank = true;
        $article->user_id = Auth::user()->id;
        $article->points = 0;

        $article->save();

        $names = User::all()->pluck('name');

        return redirect(route('article.edit', compact('article', 'names')));
    }

    public function notPublished()
    {
        $articles = Article::notPublished();

        $notPublishedCount = $articles->count();

        return view('articles.publish', compact('articles', 'notPublishedCount'));
    }

    public function publish(Article $article)
    {
        $article->update(['is_published' => true]);

        UserWriteArticle::dispatch($article);

        return redirect()->back();
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect(route('article.index'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        $names = User::all()->pluck('name');

        return view('articles.edit', compact('article', 'names'));
    }

    public function update(StoreArticle $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100|string',
            'body' => 'required|string',
        ]);

        $article->update($validatedData);
        $article->update([
            'is_blank' => false,
            'is_published' => false,
        ]);

        if (Auth::user()->is_admin) {
            $article->update([
              'user_id' => Auth::user()->where('name', $request->author)->first()->id
            ]);
        }

        return redirect(route('article.index'));
    }
}
