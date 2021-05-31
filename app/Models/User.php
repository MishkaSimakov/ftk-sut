<?php

namespace App\Models;

use App\Achievements\Chains\RatingPointChain;
use App\Enums\UserNotificationSubscriptions;
use App\Enums\UserType;
use App\Mail\ResetPasswordNotification;
use App\Models\Traits\HasRegisterCode;
use Assada\Achievements\AchievementChain;
use Assada\Achievements\Achiever;
use BenSampo\Enum\Traits\CastsEnums;
use BenSampo\Enum\Traits\QueriesFlaggedEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory;
    use Achiever;
    use CastsEnums;
    use HasRegisterCode;
    use QueriesFlaggedEnums;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'email',
        'password',
        'is_admin',
        'notification_subscriptions'
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
        'notification_subscriptions' => UserNotificationSubscriptions::class,
        'type' => UserType::class,
    ];

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this)
            ->send(new ResetPasswordNotification($token));
    }

    public function getUrlAttribute(): string
    {
        return route('users.show', $this);
    }

    public function rating_points(): HasMany
    {
        return $this->hasMany(RatingPoint::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withPivot('distance_traveled');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function liked_articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_points');
    }

    public function showPointsStatistics(): bool
    {
        return $this->type->in([\App\Enums\UserType::Pupil, \App\Enums\UserType::TeachingGraduate]);
    }

    public function lastAchievementInChainProgress(AchievementChain $chain): int
    {
        return optional(
                $this->achievementStatus(Arr::last($chain->chain()))
            )->points ?? 0;
    }
}
