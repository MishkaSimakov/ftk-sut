<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class StudentSchedule extends Model
{
	public function student() {
		return $this->belongsTo(Student::class);
	}
}
