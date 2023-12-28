<?php

namespace App\Listeners;
use App\Events\LoginComplete;
use Config;
use Illuminate\Support\Facades\Redirect;


class ForcePasswordChange
{
    public function handle(LoginComplete $event) {
        $max_pwd_age = Config::get('app.max_pwd_age');
        $pwd_age = $event->user->getPwdAge();

        if ($event->user->forcepwd || ($pwd_age >= $max_pwd_age && $max_pwd_age !== 0)) {
            return Redirect::route('user.getReset', [$event->user->id]);
        }
    }
}