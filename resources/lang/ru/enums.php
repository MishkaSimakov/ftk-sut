<?php

use App\Enums\ArticleType;
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
        UserType::TeachingGraduate => 'Преподающий выпускник клуба',
        UserType::Stranger => 'Другое',
    ],
    ArticleType::class => [
        ArticleType::Draft => 'Черновик',
        ArticleType::OnCheck => 'На проверке',
        ArticleType::Checked => 'Проверено'
    ]
];
