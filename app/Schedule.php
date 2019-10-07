<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

    public function users() {
    	return $this->belongsToMany(User::class, 'user_schedules');
    }
}
