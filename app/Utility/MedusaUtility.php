<?php

namespace App\Utility;

use App\Chapter;
use App\MedusaConfig;
use App\User;

class MedusaUtility
{
    /**
     * Return the spelled out ordinal (First, Second, Third, etc) of a number.
     *
     * @param $value
     *
     * @return string
     */
    public static function ordinal($value)
    {
        $ordinal = new \NumberFormatter('en_US', \NumberFormatter::SPELLOUT);
        $ordinal->setTextAttribute(\NumberFormatter::DEFAULT_RULESET, '%spellout-ordinal');

        return ucfirst($ordinal->format($value));
    }

    /**
     * Get the new user welcome letter and replace the tokens.
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
            '%COEMAIL%',
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
            User::getGreetingAndNameByBilletId('55fa1800e4bed82e078b4970'), 	// Fifth Space Lord
            User::getGreetingAndNameByBilletId('55fa1800e4bed82e078b4978'), 	// Marshal of the Army
            User::getGreetingAndNameByBilletId('6518978f9c6b7f0bed2f6e56'),	// Marshal of the Corp
            User::getGreetingAndNameByBilletId('55fa1800e4bed82e078b497c'),	// High Admiral, GSN
            User::getGreetingAndNameByBilletId('55fa1800e4bed82e078b497e'),	// First Space Lord
            User::getGreetingAndNameByBilletId('55fa1800e4bed82e078b4980'), 	// First Lord of the Admiralty
        ];

        if (is_null($letter) === false) {
            return str_replace($search, $replace, $letter);
        }
    }
}
