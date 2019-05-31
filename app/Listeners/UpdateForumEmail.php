<?php

namespace App\Listeners;

use App\Models\ForumUser;
use App\Events\EmailChanged;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class UpdateForumEmail.
 */
class UpdateForumEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EmailChanged $event
     *
     * @return void
     */
    public function handle(EmailChanged $event)
    {
        if ($_SERVER['HTTP_HOST'] != 'medusa.trmn.org') {
            // Local sandbox or test server, we don't want to change the forum
            \Log::info('In sandbox, forum not updated');

            return;
        }
        // Get the forum user record

        try {
            $user = ForumUser::where('user_email', $event->old_email)->firstOrFail();

            $user->user_email = $event->new_email;

            $user->save();

            return;
        } catch (ModelNotFoundException $e) {
            // No forum user, don't do anything
            return;
        }
    }
}
