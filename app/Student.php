<?php

namespace App;

use App\Achievements\Events\UserEarnedPoints;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAmount(Rating $rating, Category $category)
    {
        $point = $this->points()->where([['rating_id', $rating->id], ['category_id', $category->id]])->first();

        return $point ? $point->amount : 0;
    }

    public function award(Rating $rating, Category $category, $amount) {
        $point = Point::make();

        $point->rating_id = $rating->id;
        $point->student_id = $this->id;
        $point->category_id = $category->id;
        $point->amount = $amount;

        $point->save();

        UserEarnedPoints::dispatch($point);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'student_achievement');
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }
}
