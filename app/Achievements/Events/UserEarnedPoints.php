<?php

namespace App\Achievements\Events;

use App\Rating;
use App\Student;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserEarnedPoints
{
    use Dispatchable, SerializesModels;

    public $point;

    /**
     * Create a new event instance.
     *
     * @param Rating $rating
     * @param Student $student
     */
    public function __construct(Rating $rating, Student $student)
    {
        $this->rating = $rating;
        $this->student = $student;
    }
}
