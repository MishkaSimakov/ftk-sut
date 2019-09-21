<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

    public function user_schedules() {
    	return $this->hasMany(UserSchedule::class);
    }
}
