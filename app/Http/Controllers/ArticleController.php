<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    //

    public function index(Request $request) {
        if ($request->filter == 'newest') {
    	   $articles = Article::where('isPublished', true)->latest()->get();
        } else {
            $articles = Article::where('isPublished', true)->orderBy('points', 'desc')->get();
        }

        $notPublishedCount = Article::where('isPublished', false)->orWhere('isPublished', null)->get()->count();

    	return view('articles.index', compact('articles', 'notPublishedCount'));
    }

    public function create() {
        return view('articles.create');
    }

    public function store(Request $request) {
    	$article = Article::make();

        $article->title = $request->title;
        $article->body = $request->body;
        $article->user_id = Auth::user()->id;
        $article->points = 0;

        $article->save();

        return redirect(route('article.index'));
    }

    public function notPublished() {
        $articles = Article::where('isPublished', false)->orWhere('isPublished', null)->get();
        $notPublishedCount = $articles->count();

        return view('articles.publish', compact('articles', 'notPublishedCount'));
    }

    public function publish(Article $article) {
        $article->update(['isPublished' => true]);

        return redirect()->back();
    }

    public function destroy(Article $article) {
        $article->delete();

        return redirect()->back();
    }
}