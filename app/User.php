<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements');
    }

    public function award(Rating $rating, Category $category, $amount) {
        $point = Point::make();

        $point->rating_id = $rating->id;
        $point->user_id = $this->id;
        $point->category_id = $category->id;
        $point->amount = $amount;

        $point->save();

        \App\Achievements\UserEarnedPoints::dispatch($point);
    }

    public function getAmount(Rating $rating, Category $category)
    {
        $point = $this->points()->where([['rating_id', $rating->id], ['category_id', $category->id]])->first();

        return $point ? $point->amount : 0;
    }

    public function getRegisterLinkAttribute() {
        return route('register') . '?user_id=' . $this->id . '&register_code=' . $this->register_code;
    }

    public function getUrlAttribute() {
        return route('user.show', compact('this'));
    }

//    public function getNotGettedAchievementsAttribute() {
//        $achievements = Achievement::where('isTeacher', true)->get()->filter(function($achievement) {
//            return !UserAchievement::where([['user_id', $this->id], ['achievement_id', $achievement->id]])->exists();
//        });
//
//        return $achievements;
//    }
}
