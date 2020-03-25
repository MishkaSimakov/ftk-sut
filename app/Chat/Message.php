<?php

namespace App\Chat;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $appends = [
        'selfOwned'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function getSelfOwnedAttribute()
    {
        return $this->user_id === auth()->user()->id;
    }
}
