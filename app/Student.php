<?php

namespace App;

use App\Achievements\Events\UserEarnedPoints;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @mixin Builder
 */
class Student extends Model
{
    protected $fillable = [
        'birthday', 'admissioned_at', 'name'
    ];

    protected $dates = [
        'birthday', 'admissioned_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Student $student) {
            if (!User::where('name', $student->name)->exists()) {
                $user = User::make();

                $user->name = $student->name;
                $user->register_code = Str::random(6);

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

    public function award(Rating $rating, PointCategory $category, $amount) {
        $point = Point::make();

        $point->rating_id = $rating->id;
        $point->student_id = $this->id;
        $point->category_id = $category->id;
        $point->amount = $amount;

        $point->save();
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'student_achievements');
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }
}