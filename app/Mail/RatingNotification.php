<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Mail\Mailable;

class RatingNotification extends Mailable
{
    protected Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function build()
    {
        return $this->subject('Новый рейтинг на сайте ФТК СЮТ')->markdown('emails.rating-notification', [
            'date' => $this->date,
        ]);
    }
}
