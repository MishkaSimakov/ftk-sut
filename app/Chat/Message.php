<?php

namespace App\Chat;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Message extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'body',
        'is_edited',
        'forwarded_id'
    ];

    protected $appends = [
        'selfOwned',
        'images',
        'reply'
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

    public function getImagesAttribute()
    {
        return $this->media->map->getUrl();
    }

    public function getReplyAttribute()
    {
        return optional(Message::where('id', $this->forwarded_id)->first())->load('user');
    }
}
