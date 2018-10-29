<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Thread;
use App\Http\Controllers\Controller;
use Cmgmyr\Messenger\Models\Participant;

class MessagesController extends Controller
{
    public function __construct()
    {
        carbon_set_locale();
        
        $this->middleware('auth');
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // All threads, ignore deleted/archived participants
        //$threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        $data['threads'] = Thread::forUser($user->id)->latest('updated_at')->get();
        $data['latest_thread'] = Thread::forUser($user->id)->latest('updated_at')->first();
        $data['thread_id'] = null;
        
        if ($data['latest_thread']) {
            $data['thread_id'] = $data['latest_thread']->id;
            $data['latest_thread']->markAsRead($user->id);
        }

        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages($currentUserId)->latest('updated_at')->get();

        return view('messenger.index', $data);
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show(Request $request)
    {
        $data['thread'] = Thread::findOrFail($request->id);
        
        $user = $request->user();

        $data['thread']->getParticipantFromUser($user->id);        

        $data['thread']->markAsRead($user->id);

        $data['threads'] = Thread::forUser($user->id)->latest('updated_at')->get();

        $data['thread_id'] = $request->id;

        return view('messenger.show', $data);
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $data['threads'] = Thread::forUser($user->id)->latest('updated_at')->get();
        $data['thread_id'] = null;

        return view('messenger.create', $data);
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'recipients' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ]);

        $logged_user = $request->user();

        $recipients = explode(', ', $request->recipients);
        $recipients_ids = [];

        foreach ($recipients as $key => $recipient) {
            $user = User::whereUsername($recipient)->first();

            if ($user) {
                $recipients_ids[$key] = $user->id;
            }
        }

        if (!count($recipients_ids)) {
            return response(['message' => 'Please enter a valid recipient'], 422);
        }        

        $thread = Thread::create(['subject' => $request->subject]);

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id'   => $logged_user->id,
            'body'      => $request->body,
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => $logged_user->id,
            'last_read' => new Carbon,
        ]);

        // Recipients
        $thread->addParticipant($recipients_ids);        

        return [
            'immediate_redirect' => true,
            'redirect' => route('messages::index')  
        ];
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $thread = Thread::findOrFail($request->id);
        $user = $request->user();

        $thread->getParticipantFromUser($user->id);

        $thread->activateAllParticipants();

        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
            'body'      => $request->body,
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);
        $participant->last_read = new Carbon;
        $participant->save();        

        return [
            'owner_username' => $user->username,
            'owner_url' => $user->url,
            'owner_avatar' => $user->small_avatar,
            'body' => nl2br($message->body),
            'created_at' => $message->created_at->diffForHumans(),
        ];
    }

    public function deleteThread(Request $request)
    {
        $user = $request->user();
        $participant = Participant::whereThreadId($request->id)
                                    ->whereUserId($user->id)
                                    ->firstOrFail();

        $participant->delete();

        return [
            'success_title' => 'Success',
            'success_body' => 'Thread was successfully deleted'
        ];
    }

    public function deleteMessage(Request $request)
    {
        $user = $request->user();
        $message = Message::whereId($request->id)->whereUserId($user->id)->firstOrFail();

        $message->delete();

        return [
            'success_title' => 'Success',
            'success_body' => 'Message was successfully deleted'
        ];
    }
}
