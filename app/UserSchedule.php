<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class UserSchedule extends Model
{
	public function user() {
		return $this->belongsTo(User::class);
	}
}
