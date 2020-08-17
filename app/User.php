<?php

namespace App;

use App\Chat\Chat;
use App\Chat\ChatUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @property-read \Illuminate\Support\Collection|\App\Point[] $points
 */
class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'is_admin', 'phone', 'vk_link', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'articleCount',
        'url'
    ];

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getUrlAttribute() {
        return route('user.show', $this);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, ChatUser::class)->orderBy('last_message', 'desc');
    }

    public function isInChat(Chat $chat)
    {
        return $this->chats->contains($chat);
    }

    public function likedArticles()
    {
        return $this->belongsToMany(Article::class, UserLike::class);
    }


    public function getArticleCountAttribute()
    {
        return $this->articles()->where([['is_blank', false], ['is_published', true]])->count();
    }

    public function getArticlesPointSumAttribute()
    {
        return $this->articles()->where([['is_blank', false], ['is_published', true]])->sum('points');
    }

    public function getArticlesViewSumAttribute()
    {
        return $this->articles()->where([['is_blank', false], ['is_published', true]])->get()->sum->views;
    }


    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->getMedia()->count() ?
            $this->getMedia()->first()->getUrl() :
            'https://upload.wikimedia.org/wikipedia/commons/4/46/%D0%A1%D0%B5%D1%80%D1%8B%D0%B9_%D1%86%D0%B2%D0%B5%D1%82-_2014-03-15_18-16.jpg';
    }

    public function travels()
    {
        return $this->belongsToMany(Travel::class, 'travel_users');
    }
}
