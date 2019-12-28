<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Achievement extends Model
{
    protected $guarded = [];

    public function getIsGettedAttribute() {
    	if (Auth::user()) {
  			return StudentAchievement::where([
  			    ['achievement_id', $this->id],
                ['student_id', optional(Auth::user()->student)->id]
            ])->exists();
    	}

    	return true;
    }

    public function awardTo(User $user)
    {
        $this->users()->attach($user);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_achievements');
    }
}
