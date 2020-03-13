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

    public function users() {
    	return $this->belongsToMany(User::class, 'user_schedules');
    }

    public function getIsRegisterAttribute() {
        return UserSchedule::where([['schedule_id', $this->id], ['user_id', Auth::user()->id]])->exists();
    }
}
