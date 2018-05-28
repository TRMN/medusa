<?php

namespace App\Utility;

use App\Chapter;
use App\MedusaConfig;
use App\User;

class MedusaUtility
{

    /**
     * Return the spelled out ordinal (First, Second, Third, etc) of a number
     * @param $value
     *
     * @return string
     */

    public static function ordinal($value)
    {
        $ordinal = new \NumberFormatter('en_US', \NumberFormatter::SPELLOUT);
        $ordinal->setTextAttribute(\NumberFormatter::DEFAULT_RULESET, "%spellout-ordinal");
        return ucfirst($ordinal->format($value));
    }

    /**
     * Get the new user welcome letter and replace the tokens
     *
     * @param \App\User $user
     *
     * @return mixed|null
     */
    public static function getWelcomeLetter(User $user)
    {
        $letter = MedusaConfig::get('bupers.welcome', null);

        $search = [
            '%CHAPTER%',
            '%CO%',
            '%COEMAIL',
            '%5SL%',
            '%MOTA%',
            '%DANT%',
            '%HA%',
            '%1SL%',
            '%FLA%',
        ];

        $replace = [
            $user->getAssignmentName('primary'),
            Chapter::find($user->getAssignmentId('primary'))->getCO()->getGreetingAndName(),
            Chapter::find($user->getAssignmentId('primary'))->getCO()->email_address,
            User::where('assignment.billet', 'Fifth Space Lord')->first()->getGreetingAndName(),
            User::where('assignment.billet', 'Marshal of the Army, RMA')->first()->getGreetingAndName(),
            User::where('assignment.billet', 'Commandant, Royal Manticoran Marine Corps')->first()
                ->getGreetingAndName(),
            User::where('assignment.billet', 'High Admiral, GSN')->first()->getGreetingAndName(),
            User::where('assignment.billet', 'First Space Lord')->first()->getGreetingAndName(),
            User::where('assignment.billet', 'First Lord of the Admiralty')->first()->getGreetingAndName()
        ];

        if (is_null($letter) === false) {
            return str_replace($search, $replace, $letter);
        }

        return null;
    }
}
