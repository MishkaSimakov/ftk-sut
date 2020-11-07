<?php

namespace App\Http\Resources\News;

use App\Http\Resources\Clubs\ClubsIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsIndexResource extends JsonResource
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
            'date' => $this->date,
            'views' => 100,

            'clubs' => ClubsIndexResource::collection($this->clubs)
        ];
    }
}
