<?php

namespace App\Listeners;

use App\Events\EmailChanged;
use App\ForumUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UpdateForumEmail
 * @package App\Listeners
 *
 * Event listener to update a members email address for the forums when they change their email address
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
     * @param  EmailChanged  $event
     * @return void
     */
    public function handle(EmailChanged $event)
    {
        if($_SERVER['SERVER_NAME'] != "medusa.trmn.org") {
            // Local sandbox or test server, we don't want to change the forum
            return;
        }
        // Get the forum user record

        try {
            $user = ForumUser::where('user_email', $event->old_email)->firstOrFail();

            $user->user_email = $event->new_email;

            $user->save();
        } catch (ModelNotFoundException $e) {
            // No forum user, don't do anything
            return;
        }
    }
}
