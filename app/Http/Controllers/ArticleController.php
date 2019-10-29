<?php

namespace App\Http\Controllers;

use App\Achievements\Events\UserWriteArticle;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

        $notPublishedCount = Article::notPublished()->count();

        return view('articles.index', compact('articles', 'notPublishedCount'));
    }

    public function show(Article $article)
    {
        $notPublishedCount = Article::notPublished()->count();

        return view('articles.show', compact('article', 'notPublishedCount'));
    }

    public function create()
    {
        Article::where('is_blank', true)->delete();

        $article = Article::make();

        $article->is_blank = true;
        $article->user_id = Auth::user()->id;
        $article->points = 0;

        $article->save();

        return redirect(route('article.edit', compact('article')));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'photos' => 'mimes:jpeg,bmp,png'
        ]);

        $article = Article::make();

        $article->title = $request->title;
        $article->body = $request->body;
        $article->user_id = Auth::user()->id;
        $article->points = 0;

        $article->save();

        return redirect(route('article.index'));
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

        return redirect()->back();
    }

    public function edit(Article $article)
    {
        if (Auth::user()->id == $article->user_id) {
            return view('articles.edit', compact('article'));
        }
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100|string',
            'body' => 'required|string',
        ]);

        $article->update($validatedData);
        $article->update(['is_blank' => false]);

        return redirect(route('article.index'));
    }
}
