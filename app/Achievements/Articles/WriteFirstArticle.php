<?php
declare(strict_types=1);

namespace App\Achievements\Articles;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements\Articles
 */
class WriteFirstArticle extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Кто-то научился писать!';

    /*
     * A small description for the achievement
     */
    public $description = 'Написать первую статью.';
}