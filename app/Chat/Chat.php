<?php

namespace App\Chat;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    protected $appends = [
        'selfOwned'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, ChatUser::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at')->with('user');
    }

    public function touchLastMessage()
    {
        $this->last_message = Carbon::now();
        $this->save();
    }

    public function usersExceptCurrentlyAuthenticated()
    {
        return $this->users()->where('id', '!=', Auth::user()->id);
    }

    public function getSelfOwnedAttribute()
    {
        return $this->users()->where('is_admin', true)->first()->id == auth()->user()->id;
    }
}
