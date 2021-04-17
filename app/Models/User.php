<?php

namespace App\Models;

use App\Mail\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

// TODO: добавить свойства, которые не добавляются в JSON

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_student'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'register_code',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->register_code = Str::random(6);
        });
    }

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)
            ->send(new ResetPasswordNotification($token));
    }

    public function getUrlAttribute()
    {
        return '#';  // TODO: сделать нормальную ссылку
    }

    public function rating_points()
    {
        return $this->hasMany(RatingPoint::class);
    }


    public function scopeSearch(Builder $builder, string $query)
    {
        return $builder->where('name', 'like', "%{$query}%");
    }
}
