<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class GoTo10Travels extends AchievementType
{
    public $name = 'Походы - это круто!';
    public $description = 'Сходите в 10 походов.';
    public $icon = '';

    public function qualifier($user)
    {
        return $user->travels()->count() >= 10;
    }
}
