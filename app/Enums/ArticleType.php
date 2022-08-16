<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class ArticleType extends Enum implements LocalizedEnum
{
    const Draft = 0;
    const OnCheck = 1;
    const Checked = 2;
}
