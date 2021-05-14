<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Draft()
 * @method static static OnCheck()
 * @method static static Checked()
 */
final class ArticleType extends Enum
{
    const Draft =     0;
    const OnCheck =   1;
    const Checked =   2;
}
