<?php

namespace App;

use App\Achievements\Events\UserEarnedPoints;
use App\Chat\Chat;
use App\Chat\ChatUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

/**
 * @property-read \Illuminate\Support\Collection|\App\Point[] $points
 */
class User extends Authenticatable
{
    use Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
}
