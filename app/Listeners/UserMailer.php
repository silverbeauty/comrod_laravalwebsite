<?php

namespace App\Listeners;

use App\Mailers\UserMailer as Mailer;
use App\Events\UserHasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMailer
{
    private $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendWelcomeMessage(UserHasRegistered $event)
    {
        return $this->mailer->sendWelcomeMessage($event->user);
    }
}
