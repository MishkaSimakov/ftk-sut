<?php
declare(strict_types=1);

namespace App\Achievements\Chains;

use App\Achievements\Travels\GoTo10Travels;
use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class TravelChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new GoTo10Travels(),
        ];
    }
}
