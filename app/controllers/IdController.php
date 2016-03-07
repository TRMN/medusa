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

    public function getCard($id)
    {
        $user = User::find($id);

        if ($this->isInChainOfCommand($user) === false &&
            Auth::user()->id != $user->id &&
            $this->hasPermissions(['VIEW_MEMBERS']) === false
        ) {
            return Redirect::to(URL::previous())->with('message', 'You do not have permission to view that page');
        }

        $idCard = Image::make(public_path() . '/images/TRMN-membership-card.png');

        $idCard->text($user->getFullName(), 382, 317, function($font) {
            $font->file(public_path() . "/fonts/24bd1ba4-1474-491a-91f2-a13940159b6d.ttf");
            $font->size(48);
            $font->align('center');
        });

        $idCard->text($user->getAssignmentName('primary'), 382, 432, function($font) {
            $font->file(public_path() . "/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf");
            $font->align('center');
            $font->size(40);
        });

        $idCard->text($user->getBillet('primary'), 382, 527, function($font) {
            $font->file(public_path() . "/fonts/3df7a380-e47d-4297-a46e-d2290e876d0d.ttf");
            $font->align('center');
            $font->size(40);
        });

        $rankCode = substr($user->rank['grade'], 0, 1);

        switch($rankCode) {
            case 'C':
                switch($user->branch) {
                    case 'RMACS':
                        $rankCode .= '-AC';
                        break;
                    case 'RMMM':
                        $rankCode .= '-MM';
                        break;
                    case 'SFS':
                        $rankCode .= '-SFC';
                        break;
                    case 'INTEL':
                        $rankCode .= '-IS';
                        break;
                    case 'CIVIL':
                        $rankCode .= '-CD';
                }
                break;
            default;
                break;
        }

        $idCard->text($rankCode, 153, 638, function($font) {
            $font->file(public_path() . "/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf");
            $font->align('center');
            $font->size(40);
            $font->color('#BE1E2D');
        });

        $peerages = $user->getPeerages();

        if (empty($peerages) === false) {
            $idCard->text($peerages[0]['code'], 392, 638, function($font) {
                $font->file(public_path() . "/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf");
                $font->align('center');
                $font->size(40);
                $font->color('#BE1E2D');
        });
        }


        $idCard->text($user->branch, 628, 638, function($font) {
            $font->file(public_path() . "/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf");
            $font->align('center');
            $font->size(40);
            $font->color('#BE1E2D');
        });

        $idCard->text($user->member_id, 855, 250, function($font) {
            $font->file(public_path() . "/fonts/3df7a380-e47d-4297-a46e-d2290e876d0d.ttf");
            $font->align('center');
            $font->size(20);
        });

        $idCard->insert(base64_encode(QrCode::format('png')->margin(1)->size(150)->errorCorrection('H')->generate($user->member_id)), 'top-left', 780, 252);

        return $idCard->response();

    }

}