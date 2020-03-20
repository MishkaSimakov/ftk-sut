<?php

namespace App\Chat;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, ChatUser::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc')->with('user');
    }

    public function touchLastMessage()
    {
        $this->last_message = Carbon::now();
        $this->save();
    }
}
