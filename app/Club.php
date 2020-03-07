<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class Club extends Model
{
    public function students() {
        return $this->belongsToMany(Student::class, 'student_clubs');
    }
}
