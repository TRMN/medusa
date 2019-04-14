<?php

namespace App\Http\Controllers;

use App\User;
use App\Chapter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class IdController extends Controller
{
    /**
     * @param $id
     *
     * Generate the QRCode with the members ID and display it
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getQrcode($id)
    {
        $user = User::find($id);

        if ($this->isInChainOfCommand($user) === false &&
            Auth::user()->id != $user->id &&
            $this->hasPermissions(['VIEW_MEMBERS']) === false
        ) {
            return redirect(URL::previous())->with('message', 'You do not have permission to view that page');
        }

        return view('id.qrcode', ['member_id' => $user->member_id]);
    }

    /**
     * @param $id
     *
     * Generate and display a members membership card
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getCard($id)
    {
        $user = User::find($id);

        if ($this->isInChainOfCommand($user) === false &&
            Auth::user()->id != $user->id &&
            $this->hasPermissions(['VIEW_MEMBERS']) === false
        ) {
            return redirect(URL::previous())->with('message', 'You do not have permission to view that page');
        }

        return view('id.card', ['card' => $user->buildIdCard()]);
    }

    /**
     * @param $shipID
     *
     * Generate and display the membership cards for all members of a chapter that have that chapter as their primary
     * assigment
     *
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getBulk($shipID)
    {
        if (($redirect = $this->checkPermissions('ID_CARD')) !== true) {
            return $redirect;
        }

        $chapters = Chapter::find($shipID)->getChapterIdWithChildren();

        return view('id.bulk', ['chapters' => $chapters]);
    }

    public function getMarkbulk($shipID)
    {
        if (($redirect = $this->checkPermissions('ID_CARD')) !== true) {
            return $redirect;
        }

        $chapters = Chapter::find($shipID)->getChapterIdWithChildren();

        foreach ($chapters as $chapterId) {
            $chapter = Chapter::find($chapterId);
            foreach ($chapter->getAllCrew() as $member) {
                if (empty($member->idcard_printed)) {
                    $this->_markMember($member);
                }
            }
            $chapter->idcards_printed = true;
            $chapter->save();
        }

        return redirect(URL::previous());
    }

    public function getMark($userID)
    {
        if (($redirect = $this->checkPermissions('ID_CARD')) !== true) {
            return $redirect;
        }

        $this->_markMember($userID);

        return redirect(URL::previous());
    }

    private function _markMember($member)
    {
        if ($member instanceof User === false) {
            $member = User::find($member);
        }

        $member->idcard_printed = true;
        $member->save();
    }
}
