<?php

namespace App;

use App\Achievements\Events\UserEarnedPoints;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read \Illuminate\Support\Collection|\App\Point[] $points
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'login', 'password',
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

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getUrlAttribute() {
        return route('user.show', $this);
    }
}
