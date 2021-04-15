<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'body' => $this->truncatedBody,
            'url' => $this->url,

            'points' => $this->pointsCount,
            'is_liked' => auth()->check() ? $this->points->where([['user_id', auth()->user()->id], ['article_id', $this->id]])->exists() : false,
            'views' => rand(0, 25),

            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'url' => $this->author->url
            ],

            'date' => $this->date,
        ];
    }
}
