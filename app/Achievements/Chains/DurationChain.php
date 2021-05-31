<?php
declare(strict_types=1);

namespace App\Achievements\Chains;

use App\Achievements\Duration\VisitFor2Years;
use App\Achievements\Duration\VisitFor3Months;
use App\Achievements\Duration\VisitFor3Years;
use App\Achievements\Duration\VisitFor4Years;
use App\Achievements\Duration\VisitFor5Months;
use App\Achievements\Duration\VisitFor5Years;
use App\Achievements\Duration\VisitForYear;
use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class DurationChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new VisitFor3Months(),
            new VisitFor5Months(),
            new VisitForYear(),
            new VisitFor2Years(),
            new VisitFor3Years(),
            new VisitFor4Years(),
            new VisitFor5Years()
        ];
    }
}
