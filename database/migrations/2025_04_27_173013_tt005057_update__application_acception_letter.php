<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\MedusaConfig;

class Tt005057UpdateApplicationAcceptionLetter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the current BuPers welcome letter.
        $welcome = MedusaConfig::get('bupers.welcome');

        // Save a backup to be used by the rollback
        MedusaConfig::set('bupers.welcome.bak', $welcome);

        $newWelcome = <<<EOT
<p>%GREETING%:</p>

<p>Your application has been approved and we welcome you to The Royal Manticoran Navy: The Official Honor Harrington Fan Association (TRMN). TRMN is a chapter-based fan club, with local chapters around the world and is broken down into eight distinct branches &ndash; both military and civilian.</p>

<p>Based upon the selections you made when you applied, you are serving in the %BRANCH% assigned to %CHAPTER%.</p>

<p>New members can often feel confused or overwhelmed on what to do first and/or on how to do it. TRMN is a chapter-based organization and as such, your chapter will be your best source of information. Your commanding officer is %CO%, who can be contacted at <a href="mailto:%COEMAIL%">%COEMAIL%</a> and your Executive Officer is %XO%, whose email is <a href="mailto:%XOEMAIL%">%XOEMAIL%</a>. While we prefer that you contact and work with your CO first, you may also contact our Office of Member Services at <a href="mailto:membership@bupers.trmn.org">membership@bupers.trmn.org</a>.</p>

<p>When you have a moment, please log in to MEDUSA (our member database) and review your information. Here is where we will track the training courses you have taken and the promotion points and awards you have earned. If you need to update your personal information, just click on the &ldquo;EDIT&rdquo; button (at the bottom of the page) and make whatever changes are needed. You can also change your branch and/or chapter by clicking on the &lsquo;Member&rsquo; link in the top left-hand corner.</p>

<p>You will readily find TRMN information and resources available online. Some of the most commonly visited links can be found at:
<ul>
<li>The World Wide Web: <a href="http://www.trmn.org/">http://www.trmn.org/</a></li>
<li>The TRMN Forums (where most TRMN business is conducted): <a href="https://forums.trmn.org/">https://forums.trmn.org/</a> (This uses the same username and password you created when you joined)</li>
<li>TRMN Wiki (a Wiki of organizational knowledge and manuals): <a href="http://wiki.trmn.org/">http://wiki.trmn.org</a></li> 

<li>YouTube:<ul>
    <li>First Space Lord: <a href="https://www.youtube.com/channel/UC875JVLvwn9EUGDlDDnf2uQ">https://www.youtube.com/channel/UC875JVLvwn9EUGDlDDnf2uQ</a></li>
    <li>Bureau of Personnel: <a href="https://www.youtube.com/channel/UCyD1UY584C-tNWrKVSuJqyw">https://www.youtube.com/channel/UCyD1UY584C-tNWrKVSuJqyw</a></li>
    </ul>
</li>

<li>TRMN Discord Server: <a href="https://discord.gg/AZvztKR">https://discord.gg/AZvztKR</a></li>
<li>Bureau of Supply Store: <a href="http://store.trmn.org/">http://store.trmn.org/</a></li>
</ul>

There are many others!

<p>The TRMN also has an extensive social media presence. Our main Facebook page can be found at: <a href="https://www.facebook.com/trmn.org">https://www.facebook.com/trmn.org</a>. Many branches, fleets, bureaus, and chapters also have pages. We also have a TRMN Discord server, which we use extensively for communication. Check with your chapter CO and other chapter members to find links for both Facebook and Discord.</p>

<p>We are excited to have you with us! Come join us on-line, in person, or at a convention. This is now your club as much as it is ours and we look forward to working with you to make it even better.</p>

<p>Again, welcome to TRMN and the Honorverse.</p>
EOT;
        // Update the welcome letter with the new content.
        MedusaConfig::set('bupers.welcome', $newWelcome);

        // Get the current BuPers signature.
        $sig = MedusaConfig::get('bupers.sig');

        // Save a backup to be used by the rollback
        MedusaConfig::set('bupers.sig.bak', sig);

        $newSig = <<<EOT
 Geoff Zoeller
 Vizeadmiral, IAN
 Interim Director, Office of Member Services - BuPers
EOT;

        // Update the welcome signature with the new content.
        MedusaConfig::set('bupers.sig', $newSig);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reset the welcome letter from the backup.
        MedusaConfig::set('bupers.welcome', MedusaConfig::get('bupers.welcome.bak'));
        MedusaConfig::remove('bupers.welcome.bak');

        // Reset the signature from the backup.
        MedusaConfig::set('bupers.sig', MedusaConfig::get('bupers.sig.bak'));
        MedusaConfig::remove('bupers.sig.bak');
    }
}
