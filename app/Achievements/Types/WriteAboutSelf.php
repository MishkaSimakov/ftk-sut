<?php

namespace App\Achievements\Types;

use App\Achievements\AchievementType;


class WriteAboutSelf extends AchievementType
{
    public $name = 'О себе любимом';
    public $description = 'Напишите что-нибудь о себе, используя вкладку "Настройки аккаунта"';
    public $icon = 'https://i.pinimg.com/originals/c7/80/5e/c7805ee9aa1a16baaa33a7b1be2f220e.png';

    public function qualifier($user)
    {
        return $user->description !== null;
    }
}
