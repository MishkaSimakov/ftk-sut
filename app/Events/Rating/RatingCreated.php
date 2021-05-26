<?php

namespace App\Events\Rating;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;

class RatingCreated
{
    use Dispatchable;

    public Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }
}
