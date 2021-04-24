<?php
declare(strict_types=1);

namespace App\Achievements\Rating;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Rating
 */
class GetLessThat0RatingPoints extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Под бедроком';

    /*
     * A small description for the achievement
     */
    public $description = 'Получить отрицательное количество очков в рейтинге.';
}
