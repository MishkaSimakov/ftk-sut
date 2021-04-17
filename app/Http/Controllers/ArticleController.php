<?php

namespace App\Http\Controllers;

use App\Enums\ArticleType;
use App\Http\Requests\Articles\StoreArticleRequest;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        return response()->view('articles.index');
    }

    public function create()
    {
        return response()->view('articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $article = new Article;

        $article->title = $request->get('title');

        $body = $request->get('body');
        preg_match_all('/<img.*?src=[\'"](.*?)[\'"].*?>/i', $body, $matches);
        $images = $matches[1];

        foreach ($images as $image) {
            if (preg_match('/^data:image\/(\w+);base64,/', $image)) {
                $body = str_replace($image, asset(
                    'storage/' . save_base64($image, 'articles/', 'public')
                ), $body);
            }
        }
        $article->body = $body;

        $article->author()->associate($request->user());

        $article->date = $request->get('delayed_publication') == 'on' ? $request->get('date') : now();
        $article->type = $request->user()->is_admin ? ArticleType::Published() : ArticleType::OnCheck();

        $article->save();

        return redirect()->route('article.index');
    }

    public function show(Article $article)
    {

        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.index');
    }

    public function unpublished()
    {
        $articles = ArticleIndexResource::collection(
            Article::where('type', ArticleType::OnCheck())->orderBy('date', 'desc')->get()
        );

        return view('articles.unpublished', compact('articles'));
    }
}
