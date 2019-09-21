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

    public function getRegisterLinkAttribute() {
        return route('register') . '?user_id=' . $this->id . '&register_code=' . $this->register_code;
    }

    public function getUrlAttribute() {
        return route('user.show', compact('this'));
    }

    public function setIncrementPointsAttribute($point_count) {
        $rating = Rating::where([['isMonthly', '=', false], ['isTeachers', '=',true]])->get()->sortByDesc('date')->first();

        if ($rating) {
            $point = $rating->points->where('user_id', $this->id)->first();
        } else {
            $rating = Rating::make();

            $rating->date = Carbon::now();
            $rating->isMonthly = false;
            $rating->isTeachers = true;

            $rating->save();

            $point = $rating->points->where('user_id', $this->id)->first();
        }

        if (!$point) {
            $point = Point::make();

            $point->user_id = $this->id;
            $point->rating_id = $rating->id;

            $point->points = $point_count;

            $point->points_travels = 0;
            $point->points_local_competition = 0;
            $point->points_global_competition = 0;
            $point->points_games = 0;
            $point->points_lessons = 0;
            $point->points_press = 0;

            $point->place = 0;

            $point->save();
        } else {
            $point->increment('points', $point_count);
        }
    }

    public function setDecrementPointsAttribute($point_count) {
        $rating = Rating::where([['isMonthly', '=', false], ['isTeachers', '=', true]])->get()->sortByDesc('date')->first();

        if ($rating) {
            $point = $rating->points->where('user_id', $this->id)->first();
        } else {
            $rating = Rating::make();

            $rating->date = Carbon::now();
            $rating->isMonthly = false;
            $rating->isTeachers = true;

            $rating->save();

            $point = $rating->points->where('user_id', $this->id)->first();
        }

        if (!$point) {
            $point = Point::make();

            $point->user_id = $this->id;
            $point->rating_id = $rating->id;

            $point->points = 0 - $point_count;

            $point->points_travels = 0;
            $point->points_local_competition = 0;
            $point->points_global_competition = 0;
            $point->points_games = 0;
            $point->points_lessons = 0;
            $point->points_press = 0;

            $point->place = 0;

            $point->save();
        } else {
            $point->decrement('points', $point_count);
        }
    }

    public function getPointCountAttribute() {
        $rating = Rating::where([['isMonthly', false], ['isTeachers', true]])->get()->sortByDesc('date')->first();

        if ($rating) {
            $point = $rating->points->where('user_id', $this->id)->first();

            if ($point) {
                return $point->points;
            }
        }

        return 0;
    }

    public function getNotGettedAchievementsAttribute() {
        $achievements = Achievement::where('isTeacher', true)->get()->filter(function($achievement) {
            return !UserAchievement::where([['user_id', $this->id], ['achievement_id', $achievement->id]])->exists();
        });

        return $achievements;
    }
}
