<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return route('teacher.show', $this);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
