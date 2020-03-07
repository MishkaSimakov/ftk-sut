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

    protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

    public function students() {
    	return $this->belongsToMany(Student::class, 'student_schedules');
    }

    public function getIsRegisterAttribute() {
        return StudentSchedule::where([['schedule_id', $this->id], ['student_id', optional(Auth::user()->student)->id]])->exists();
    }
}
