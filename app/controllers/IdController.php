<?php

class IdController extends \BaseController
{

    public function getQrcode($id)
    {
        $user = User::find($id);

        if ($this->isInChainOfCommand($user) === false &&
            Auth::user()->id != $user->id &&
            $this->hasPermissions(['VIEW_MEMBERS']) === false
        ) {
            return Redirect::to(URL::previous())->with('message', 'You do not have permission to view that page');
        }

        return View::make('id.qrcode', ['member_id' => $user->member_id]);
    }

}