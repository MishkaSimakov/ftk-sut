<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function getFullNameAttribute()
    {
        return implode(" ", [
            $this->last_name,
            $this->first_name,
            $this->middle_name,
        ]);
    }

    public function getUrlAttribute()
    {
        return route('teacher.show', compact('this'));
    }
}
