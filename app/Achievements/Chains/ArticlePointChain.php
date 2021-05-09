<?php
declare(strict_types=1);

namespace App\Achievements\Chains;

use App\Achievements\Articles\Points\Set10Likes;
use App\Achievements\Articles\Points\SetFirstLike;
use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class ArticlePointChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new SetFirstLike(),
            new Set10Likes()
        ];
    }
}
