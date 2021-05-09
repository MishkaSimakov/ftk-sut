<?php
declare(strict_types=1);

namespace App\Achievements\Chains;

use App\Achievements\Rating\Monthly\GetMoreThan1000RatingPoints;
use App\Achievements\Rating\Monthly\GetMoreThan10000RatingPoints;
use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class RatingPointChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new GetMoreThan1000RatingPoints(),
            new GetMoreThan10000RatingPoints(),
        ];
    }
}
