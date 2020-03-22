<?php

namespace App\Chat;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $fillable = [
        'is_unread'
    ];
}
