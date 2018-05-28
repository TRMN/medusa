<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionTextBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $blocks = [
            'promotions.instructions' => '<p>This page will show all eligible promotions for CHAPTER as well as
                any children/subordinate chapters. Up to five tables will be shown, and a member
                could appear in more than one. The four possible tables are:</p>
            <ul>
                <li>Eligible for Early Promotion</li>
                <li>Eligible for Promotion</li>
                <li>Eligible for Merit Promotion</li>
                <li>Recommend for Warrant</li>
                <li>Eligible for Promotion Board</li>
            </ul>
            <p>The first two should be self explanatory. A member will only show up in one of these tables if they are
                eligible to be promoted by you, To select a member for promotion, just click the checkbox to the
                left of their name. If you wish to select all of them, just click the checkbox in the header next to
                "All". If you change your mind, if you click the checkbox in the header again, they will all be
                unselected. The other two tables.</p>
             <p><strong>Eligible for Merit Promotion</strong> are NCO\'s that qualify for a merit promotion to O-1 based
             on Time in Grade, promotion points and exams. <strong>Recommend for Warrant</strong> and <strong>Eligible for
                    Promotion Board</strong> are informational. They are there to quickly show you which of your members
                should be sent to a promotion board or that you can recommend to the First Lord of the Admiralty for a
                Warrant.
            </p>',
            'promotions.enlisted' => '<p>The Enlisted Promotions Board convenes for Enlisted Promotions for Senior Chief Petty Officer (E-8), Master Chief Petty Officer (E-9) and Senior Master Chief Petty Officer (E-10). A Commanding Officer may issue a Brevet Promotion to Chief Petty Officer (E-7) but it may be audited by this Promotions Board at its next sitting if questions arise. The Enlisted Promotions Board will meet every other Month starting in February.</p>',
            'promotions.warrant' => '<p>The Warrant Promotions Board convenes for all Warrant Officer Promotions. It does not issue original Warrants. Those are issued by the First Lord of the Admiralty. The Warrant Promotions Board will meet the first month of every Quarter starting with January.</p>',
            'promotions.officer' => '<p>The Officer One Promotions Board convenes for all Promotions for Lieutenant Senior Grade (O-3) and Lieutenant Commanders (O-4). The Officer One Promotions Board will meet every other Month starting in February.</p>
            <p>The Officer Two Promotions Board convenes for all Promotions for Commander (O-5) and Captain Junior Grade (O-6a). The Officer Two Promotions Board will meet every other Month starting in January.</p>',
            'promotions.flag' => '<p>A Flag Promotions Board shall be convened for every Flag Promotion of Rear Admiral (F-2) and higher. The Flag Officer Promotions Board will meet every other Quarter starting with April.</p>',
        ];

        foreach($blocks as $key => $block) {
            \App\MedusaConfig::set($key, $block);
        }
;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(['promotions.instructions', 'promotions.enlisted', 'promotions.warrant', 'promotions.officer', 'promotions.flag'] as $key) {
            \App\MedusaConfig::remove($key);
        }
    }
}
