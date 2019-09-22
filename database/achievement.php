<?php

$achievements = [
    'rating' => [
        [
            'title' => 'Ну это уже много',
            'body' => 'Набрать 10000 очков в ежемесячном рейтинге',
            'code' => 'if ($point->points > 10000) { getAchievement(); }'
        ],
        [
            'title' => 'В следующий раз повезёт',
            'body' => 'Набрать меньше 250 очков в ежемесячном рейтинге',
            'code' => 'if ($point->points < 250) { getAchievement(); }'
        ]
    ],
    'period' => [
        [
        'title' => 'Отважный новичок',
        'body' => 'Попасть в 2 рейтинга',
        'code' => '
            incrementAchievementProgress(1); if (GetUserAchievement($point->user, $achievement)->progress >= 2) { getAchievement(); }'
        ]
    ]
];
