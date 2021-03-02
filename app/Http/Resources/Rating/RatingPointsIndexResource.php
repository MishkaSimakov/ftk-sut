<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingPointsIndexResource extends JsonResource
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
            'user' => [
                'id' => $this->first()->user->id,
                'name' => $this->first()->user->name,
                'url' => $this->first()->user->url,
            ],

            'points' => RatingPointResource::collection($this),
            'total' => $this->pluck('amount')->sum(),
        ];
    }
}
