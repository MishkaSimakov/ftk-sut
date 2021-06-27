<?php

namespace App\Listeners\News;

use NewsPublished;

class SendNewsPublishedNotificationListener
{
    public function __construct()
    {
        //
    }

    public function handle(NewsPublished $event)
    {

    }
}
