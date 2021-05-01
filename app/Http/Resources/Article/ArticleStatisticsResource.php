<?php

namespace App\Http\Resources\Article;

use App\Enums\ArticleType;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Article */
class ArticleStatisticsResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,

            'isPublished' => $this->type == ArticleType::Published() and $this->is_published,

            'views_count' => $this->views_count,
            'points_count' => $this->points_count,

            'date' => $this->date,

            'url' => $this->url
        ];
    }
}
