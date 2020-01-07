<?php

namespace App;

use App\Achievements\Events\UserEarnedPoints;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Student extends Model
{
    protected $fillable = [
        'name', 'birthday'
    ];

    protected $dates = [
        'birthday'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Student $student) {
            if (!User::where('name', $student->name)->exists()) {
                $user = User::make();

                $user->password = Hash::make(Str::limit(8));
                $user->name = $student->name;

                $user->save();

                $student->user_id = $user->id;
            } else {
                $student->user_id = User::where('name', $student->name)->first()->id;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAmount(Rating $rating, PointCategory $category)
    {
        $point = $this->points()->where([['rating_id', $rating->id], ['category_id', $category->id]])->first();

        return $point ? $point->amount : 0;
    }

    public function award(Rating $rating, PointCategory $category, $amount) {
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
