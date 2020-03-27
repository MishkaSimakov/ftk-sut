<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Article $article)
    {
        return $article->comments->load(['user']);
    }

    public function store(Article $article, StoreCommentRequest $request)
    {
        $this->middleware(['auth']);

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = $request->user()->id;
        $comment->article_id = $article->id;

        $comment->save();

        return response()->json($comment->load(['user']));
    }
}
