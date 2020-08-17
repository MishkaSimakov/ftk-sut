<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'travel_users')->withPivot('distance');
    }
}
