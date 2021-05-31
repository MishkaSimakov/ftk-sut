<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class TravelType extends Enum implements LocalizedEnum
{
    const Hiking = 0;
    const Bike = 1;
}
