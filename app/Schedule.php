<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


/**
 * @mixin Builder
 */
class Schedule extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

    protected $appends = [
        'isRegister'
    ];

    public function users() {
    	return $this->belongsToMany(User::class, 'user_schedules');
    }

    public function getIsRegisterAttribute() {
        return $this->users->contains(auth()->user());
    }

    public function getIsArchivedAttribute()
    {
        return $this->date_end->isBefore(now());
    }

    public function getImageUrlAttribute()
    {
        return $this->getMedia()->count() ?
            $this->getMedia()->first()->getUrl() :
            "https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw_400x400.jpg";
    }

    public function scopeArchived()
    {
        return Schedule::where('date_end', '<=', now());
    }

    public function scopeFuture()
    {
        return Schedule::where('date_end', '>', now());
    }
}
