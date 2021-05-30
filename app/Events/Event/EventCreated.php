<?php

namespace App\Events\Event;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;

class EventCreated
{
    use Dispatchable;

    protected Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }
}
