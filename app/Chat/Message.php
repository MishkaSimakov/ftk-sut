<?php

namespace App\Chat;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $appends = [
        'timeForHuman'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function getTimeForHumanAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : null;
    }
}
