<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingPointsIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $total = $this->pluck('amount')->sum();

        return [
            'user' => [
                'id' => $this->first()->user->id,
                'name' => $this->first()->user->name,
                'url' => $this->first()->user->url,
            ],

            'points' => $this->map(function ($point) use ($total) {
                return [
                    'id' => $point->id,

                    'category' => $point->category->id,

                    'amount' => $point->amount,
                    'width' => abs($point->amount / $total * 100),
                ];
            }),
            'total' => $total,
        ];
    }
}
