<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleComments extends Component
{
    public Article $article;
    public string $comment = '';

    public function send()
    {
        if (!auth()->check()) {
            return;
        }

        if (!$this->comment) {
            return;
        }

        $this->article->comments()->create([
            'body' => $this->comment,
            'user_id' => auth()->user()->id
        ]);

        $this->comment = '';
    }

    public function render()
    {
        $comments = $this->article->comments()->with('user')->orderByDesc('created_at')->get();

        return view('livewire.articles.article-comments', [
            'comments' => $comments
        ]);
    }
}
