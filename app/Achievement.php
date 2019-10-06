<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Achievement extends Model
{
    protected $guarded = [];

    public function getIsGettedAttribute() {
    	if (Auth::user()) {
  			if (UserAchievement::where([['achievement_id', $this->id], ['user_id', Auth::user()->id]])->exists()) {
                return UserAchievement::where([['achievement_id', $this->id], ['user_id', Auth::user()->id]])->first()->completed;
            }

            return false;
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
