<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class UserType extends Enum implements LocalizedEnum
{
    const Pupil = 0;
    const Teacher = 1;
    const TeachingGraduate = 2; // Отдельный enum для Дарьи Сергеевны
    const Stranger = 3;
}
