<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Achievement extends Model
{
    //

    public function getIsGettedAttribute() {
    	if (Auth::user()) {
  			if (UserAchievement::where([['achievement_id', $this->id], ['user_id', Auth::user()->id]])->exists()) {
                return UserAchievement::where([['achievement_id', $this->id], ['user_id', Auth::user()->id]])->first()->completed;
            }

            return false;
    	}

    	return true;
    }
}
