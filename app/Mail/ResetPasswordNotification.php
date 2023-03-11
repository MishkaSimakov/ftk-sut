<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ссылка для сброса пароля на сайте ftksut.ru')->markdown('emails.user.passwords.reset', [
            'token' => $this->token,
        ]);
    }
}
