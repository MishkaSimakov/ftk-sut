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
                'id' => $this->id,
                'name' => $this->name
            ],
            'total' => $this->rating_points->sum('amount'),
            'points' => $this->rating_points->map(function ($point) {
                return [
                    'id' => $point->category->id,
                    'amount' => $point->amount,
                    'color' => $point->category->color,
                    'name' => $point->category->name,

                    'width' => $point->amount / $this->rating_points->sum('amount') * 100
                ];
            }),
        ];
    }
}
