<?php

namespace App\Http\Controllers;

use App\Achievements\Events\UserWriteArticle;
use App\Http\Requests\StoreArticle;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');

            $articles = Article::where('title', 'like', "%" . $query . "%")
//                ->orWhereHas('tags', function ($q) use ($query) {
//                    $q->where('name', 'like', "%" . $query . "%");
//                })
//                ->orWhereHas('users', function ($q) use ($query) {
//                    $q->where('name', 'like', "%" . $query . "%");
//                })
//                ->orWhere('tags.name', $query)
                ->where('is_published', true);
        } else {
            $articles = Article::where('is_published', true);
        }

        if ($request->tag) {
            $tag = $request->tag;

            $articles = $articles->whereHas('tags', function ($q) use ($tag) {
                return $q->where('name', $tag);
            });
        }

        if ($request->filter == 'newest') {
            $articles = $articles->latest();
        } else {
            $articles = $articles->orderBy('points', 'desc');
        }

        $articles = $articles->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        views($article)->cooldown(now()->addHours(1))->record();

        return view('articles.show', compact('article'));
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

        return view('articles.publish', compact('articles'));
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

        $article->tags()->sync([]);

        foreach (json_decode($request->tags) as $tag) {
            $tag_id = Tag::firstOrCreate(['name' => $tag->value]);

            $article->tags()->syncWithoutDetaching($tag_id);
        }

        if (Auth::user()->is_admin) {
            $article->update([
              'user_id' => Auth::user()->where('name', $request->author)->first()->id
            ]);
        }

        return redirect(route('article.index'));
    }
}
