<?php

namespace App\Achievements\Events;

use App\Rating;
use App\Student;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserEarnedPoints
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Rating $rating
     * @param Student $student
     * @param array $points
     */
    public function __construct(Rating $rating, Student $student, array $points)
    {
        $this->rating = $rating;
        $this->student = $student;
        $this->points = $points;
    }
}
