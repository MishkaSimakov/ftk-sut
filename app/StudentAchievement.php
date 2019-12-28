<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAchievement extends Model
{
    protected $table = 'student_achievement';
    protected $fillable = ['progress', 'completed'];
}
