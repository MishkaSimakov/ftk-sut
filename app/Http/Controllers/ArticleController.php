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
            $articles = Article::where('isPublished', true)->latest();
        } else {
            $articles = Article::where('isPublished', true)->orderBy('points', 'desc');
        }

        $articles = $articles->paginate(10);

        $notPublishedCount = Article::where('isPublished', false)->orWhere('isPublished', null)->get()->count();

        return view('articles.index', compact('articles', 'notPublishedCount'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
        $dom = new \DOMDocument();
        $dom->loadHtml($request->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {
            $src = $image->getAttribute('src');

            if(preg_match('/data:image/', $src)){

                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];

                // Generating a random filename
                $filename = uniqid();
                $filepath = storage_path('images') . "/" . $filename . "." . $mimetype;

                Image::make($src)
                    ->resize(100, 100)
                    ->encode($mimetype, 50)
                    ->save($filepath);

                $new_src = asset($filepath);
                $image->setAttribute('src', $new_src);
            }
        }

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
        $articles = Article::where('isPublished', false)->orWhere('isPublished', null)->get();
        $notPublishedCount = $articles->count();

        return view('articles.publish', compact('articles', 'notPublishedCount'));
    }

    public function publish(Article $article)
    {
        $article->update(['isPublished' => true]);

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

        return redirect(route('article.index'));
    }
}
