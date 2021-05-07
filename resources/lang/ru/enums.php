<?php

use App\Enums\TravelType;
use App\Enums\UserType;

return [
    TravelType::class => [
        TravelType::Bike => 'Велосипедный',
        TravelType::Hiking => 'Пеший',
    ],
    UserType::class => [
        UserType::Pupil => 'Ученик',
        UserType::Teacher => 'Преподаватель',
    ],
];
