<?php

namespace App\Http\Resources\Rating;

use App\Models\RatingPoint;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingPointResource extends JsonResource
{
    public $collect = RatingPoint::class;

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

            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'color' => $this->category->color,
            ],

            'amount' => $this->amount,
            'width' => 10,
        ];
    }
}
