<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArticleIndexResource extends JsonResource
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
            'body' => $this->replaceImages($this->body, $this->getMedia()),

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
            'comments_count' => $this->comments()->count(),
        ];
    }

    protected function replaceImages($body, $images) {
        return str_replace(
            $images->map->getFullUrl()->toArray(),
            $images->map->getFullUrl('thumb')->toArray(),
            $body
        );
    }
}
