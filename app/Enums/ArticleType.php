<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ArticleType extends Enum
{
    const Draft = 0;
    const OnCheck = 1;
    const Checked = 2;
}
