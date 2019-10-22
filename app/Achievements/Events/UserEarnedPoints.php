<?php

namespace App\Achievements\Events;

use App\Point;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserEarnedPoints
{
    use Dispatchable, SerializesModels;

    public $point;

    /**
     * Create a new event instance.
     *
     * @return void
     * @var $point
     */
    public function __construct(Point $point)
    {
        $this->point = $point;
    }
}
