<?php
declare(strict_types=1);

namespace App\Achievements\Chains;

use App\Achievements\Articles\Write100Articles;
use App\Achievements\Articles\Write10Articles;
use App\Achievements\Articles\Write25Articles;
use App\Achievements\Articles\Write50Articles;
use App\Achievements\Articles\Write5Articles;
use App\Achievements\Articles\WriteFirstArticle;
use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class ArticleChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new WriteFirstArticle(),
            new Write5Articles(),
            new Write10Articles(),
            new Write25Articles(),
            new Write50Articles(),
            new Write100Articles(),
        ];
    }
}
