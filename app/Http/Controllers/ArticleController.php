<?php

namespace App\Http\Controllers;

use App\Achievements\Events\UserWriteArticle;
use App\Http\Requests\StoreArticle;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Http\Resources\Article\ArticleShowResource;
use App\Tag;
use App\User;
use App\Vote;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);
        $this->middleware('admin', [
            'only' => ['notPublished', 'publish']
        ]);
    }

    public function index()
    {
        return view('articles.index');
    }

    public function show(Article $article)
    {
        views($article)->cooldown(now()->addHours(1))->record();

        $article->load(['comments', 'users']);

        return view('articles.show', compact('article'));
    }

    public function create()
    {
        Article::blank()->get()->each->delete();

        $article = Article::create([
            'is_blank' => true,
            'is_published' => false,
            'user_id' => auth()->user()->id,
            'points' => 0
        ]);

        return redirect(route('article.edit', compact('article')));
    }

    public function notPublished()
    {
        $articles = Article::notPublished()->get();

        return view('articles.publish', compact('articles'));
    }

    public function publish(Article $article)
    {
        $article->update([
            'is_published' => true,
            'is_blank' => false
        ]);

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
        $this->authorize('update', $article);

        $names = User::all()->pluck('name');
        $is_draftable = Article::draft()->where('user_id', auth()->user()->id)
            ->count() < 10;

        return view('articles.edit', compact('article', 'names', 'is_draftable'));
    }

    public function update(StoreArticle $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100|string',
            'body' => 'required|string',
        ]);

        $article->update($validatedData);
        $article->update([
            'length' => $this->countLength($validatedData['body']),
            'is_blank' => $request->is_blank == true,
            'is_published' => $request->is_blank == true,
        ]);

        if ($request->tags) {
            $article->tags()->sync([]);

            foreach (json_decode($request->tags) as $tag) {
                $tag_id = Tag::firstOrCreate(['name' => $tag->value]);

                $article->tags()->syncWithoutDetaching($tag_id);
            }
        }

        if (Auth::user()->is_admin) {
            $article->update([
              'user_id' => Auth::user()->where('name', $request->author)->first()->id
            ]);
        }

        return redirect(route('article.index'));
    }

    public function draft() {
        $articles = Article::draft()->where('user_id', auth()->user()->id)->get();

        return view('articles.draft', compact('articles'));
    }

    public function statistics()
    {
        return view('articles.statistics');
    }


    // help functions
    protected function countLength($body) {
        return str_word_count(strip_tags($body), 0, "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя");
    }
}
