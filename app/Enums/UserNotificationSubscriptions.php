<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

/**
 * @method static static NewsNotifications()
 * @method static static ArticleNotifications()
 * @method static static RatingNotifications()
 * @method static static EventNotifications()
 */
final class UserNotificationSubscriptions extends FlaggedEnum
{
    const NewsNotifications =       1 << 0;
    const ArticleNotifications =    1 << 1;
    const RatingNotifications =     1 << 2;
    const EventNotifications  =     1 << 3;

    public static function defaultFlags()
    {
        return self::flags([
            self::NewsNotifications,
            self::RatingNotifications,
            self::EventNotifications
        ]);
    }
}
