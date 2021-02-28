<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingPoint extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m';
    protected $fillable = ['rating_id', 'rating_point_category_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(RatingPointCategory::class, 'rating_point_category_id');
    }
}
