<?php

namespace App\Models;

use App\Enums\TravelType;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travels';

    protected $fillable = [
        'distance', 'type'
    ];

    public function isHiking(): bool
    {
        return $this->type == TravelType::Hiking;
    }
}
