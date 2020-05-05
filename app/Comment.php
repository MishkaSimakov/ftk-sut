<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body'
    ];

    protected $appends = [
        'selfOwned'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSelfOwnedAttribute()
    {
        return $this->user->id === optional(auth()->user())->id;
    }
}
