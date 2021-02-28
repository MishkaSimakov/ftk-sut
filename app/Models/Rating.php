<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['is_monthly', 'date'];
    protected $dates = ['date'];

    public function points()
    {
        return $this->hasMany(RatingPoint::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'rating_points')->distinct();
    }
}
