<?php
declare(strict_types=1);

namespace App\Achievements;

use App\Achievements\Articles\Write10Articles;
use App\Achievements\Articles\WriteFirstArticle;
use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class WriteArticleChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new WriteFirstArticle(),
            new Write10Articles(),
        ];
    }
}
