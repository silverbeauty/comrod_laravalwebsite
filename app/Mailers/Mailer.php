<?php

namespace App\Mailers;

use Illuminate\Contracts\Mail\Mailer as Mail;

abstract class Mailer
{
    private $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function send($user, $subject, $view, $data = [])
    {
        $this->mail->queueOn('comroads', $view, $data, function ($message) use($user, $subject) {
            $name = null;
            $firstname = $user->firstname;
            $lastname = $user->lastname;

            if (!is_null($firstname) && !is_null($lastname)) {
                $name = $firstname.' '.$lastname;
            }

            $message->to($user->email, $name)
                    ->subject($subject);
        });
    }
}