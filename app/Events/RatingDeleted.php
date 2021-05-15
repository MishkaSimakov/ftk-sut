<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;

class RatingDeleted
{
    use Dispatchable;

    public Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }
}
