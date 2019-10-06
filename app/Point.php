<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function award($category, $amount) {
        $category = Category::where('');
    }

    public function rating() {
        return $this->belongsTo(Rating::class);
    }
}
