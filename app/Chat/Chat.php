<?php

namespace App\Chat;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, ChatUser::class);
    }
}
