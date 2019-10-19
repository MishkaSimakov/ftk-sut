<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //

    protected $fillable = [
        'user_id',
        'date',
        'points_travels',
        'points_local_competition',
        'points_global_competition',
        'points_games',
        'points_lessons',
        'points_press',
        'place'
    ];

    protected $dates = ['created_at', 'updated_at', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating() {
        return $this->belongsTo(Rating::class);
    }
}
