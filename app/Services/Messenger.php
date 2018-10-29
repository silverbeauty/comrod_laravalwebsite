<?php

namespace App\Services;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;

class Messenger
{
    public static function send(array $attributes)
    {
        $thread = Thread::create(['subject' => $attributes['subject']]);

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id'   => $attributes['sender_id'],
            'body'      => $attributes['body'],
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => $attributes['sender_id'],
            'last_read' => new Carbon,
        ]);

        // Recipients
        $thread->addParticipant($attributes['recipients']);
    }
}