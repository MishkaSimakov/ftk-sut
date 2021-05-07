<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Article\ArticleStatisticsResource;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserPrivateResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'register_code' => $this->register_code,
            'url' => $this->url,
        ];
    }
}
