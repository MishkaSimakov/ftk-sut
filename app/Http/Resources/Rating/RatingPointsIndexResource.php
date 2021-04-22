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
            'user' => $this->first()->get('user'),

            'points' => $this->map(function (Collection $point, int $category_id) use ($total) {
                return [
                    'id' => 1,
                    'category' => $category_id,

                    'amount' => $point->get('amount'),
                    'width' => abs($point->get('amount') / $total * 100),
                ];
            })->values(),
            'total' => $total,
        ];
    }
}
