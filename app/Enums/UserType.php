<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Pupil()
 * @method static static Teacher()
 * @method static static Stranger()
 */
final class UserType extends Enum implements LocalizedEnum
{
    const Pupil = 0;
    const Teacher = 1;
    const Stranger = 2;
}
