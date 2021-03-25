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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('articles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
