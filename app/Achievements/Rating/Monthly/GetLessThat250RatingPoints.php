<?php
declare(strict_types=1);

namespace App\Achievements\Rating\Monthly;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Rating
 */
class GetLessThat250RatingPoints extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'В следующий раз повезёт';

    /*
     * A small description for the achievement
     */
    public $description = 'Получить меньше 250 очков в ежемесячном рейтинге';
}
