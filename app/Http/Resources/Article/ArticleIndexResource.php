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

            'points' => rand(0, 25),
            'views' => rand(0, 25),

            'is_liked' => rand(0, 1) > 0,

            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'url' => $this->author->url
            ],

            'date' => $this->date,
        ];
    }
}
