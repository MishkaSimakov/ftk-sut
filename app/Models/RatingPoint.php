<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingPoint extends Model
{
    use HasFactory;

    protected $fillable = ['rating_id', 'rating_point_category_id', 'amount'];
}
