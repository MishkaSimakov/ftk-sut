<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteOption extends Model
{
    protected $appends = [
        'percent',
        'selected'
    ];

    protected $fillable = [
        'vote_id',
        'title'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_votes', 'option_id');
    }

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    public function getPercentAttribute()
    {
        if ($this->vote->users->count()) {
            return $this->users->count() / $this->vote->users->count() * 100;
        }

        return 0;
    }

    public function getSelectedAttribute()
    {
        return $this->users->contains(auth()->user());
    }
}
