<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $appends = [
        'editable'
    ];

    public function options()
    {
        return $this->hasMany(VoteOption::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_votes');
    }

    public function getEditableAttribute()
    {
        if (auth()->check()) {
            return auth()->user()->id;
        }

        return false;
    }
}
