<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,

            'url' => $this->url,
            'views' => $this->views,
            'date' => $this->created_at->locale('ru')->isoFormat('D MMMM Y'),

            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'url' => $this->user->url
            ],
            'users' => $this->users->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name
                ];
            }),

            'tags' => $this->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name
                ];
            }),
            'comments_count' => $this->comments()->count()
        ];
    }
}
