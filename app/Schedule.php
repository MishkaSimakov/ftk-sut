<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Schedule extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $dates = ['created_at', 'updated_at', 'date_start', 'date_end'];

    public function students() {
    	return $this->belongsToMany(Student::class, 'student_schedules');
    }
}
