<?php

namespace App\Http\Resources\Rating;

use App\Models\RatingPoint;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

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
            'user' => $this->first()->user->only('id', 'name', 'url'),

            'points' => $this->map(function (RatingPoint $point) use ($total) {
                return [
                    'id' => $point->id,
                    'category' => $point->rating_point_category_id,

                    'amount' => $point->amount,
                    'width' => abs($point->amount / $total * 100),
                ];
            }),
            'total' => $total,
        ];
    }
}
