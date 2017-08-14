<!DOCTYPE html>
<html>
<body>
<table border="0">
    <tr>
        <td valign="middle"><img src="{!!$message->embed(public_path() . '/images/shoulder-patch.png')!!}"
                                 alt="Rampant Manticore"/></td>
        <td valign="middle" align="center"><h2>THE ROYAL MANTICORAN NAVY<br/>OFFICE OF THE FIFTH SPACE LORD<br/>BUREAU
                OF PERSONNEL<br/>ADMIRALTY HOUSE<br/>LANDING</h2></td>
        <td valign="middle"><img src="{!!$message->embed(public_path() . '/images/bupers.png')!!}" alt="BuPers"/></td>
    </tr>
</table>

<p>Greetings and welcome aboard The Royal Manticoran Navy, The Official Honor Harrington Fan Association (TRMN). You
    have begun an epic and exciting adventure with a new and different type of Science Fiction Fan Club. What makes TRMN
    such a different and unique club? You do! We are collectively a different type of fan club, because all of our
    members, their uniqueness, their talents, their skills. In addition TMRN is different because our leadership has
    been specifically selected by David Weber himself. David’s direct involvement in the TRMN gives us many advantages;
    the greatest among them is that we have been invited to become part of his family.
</p>

<p>I am Rear Admiral Kim Niemeyer (RMN), Fifth Space Lord and head of the Bureau of Personnel (BuPers). On behalf of the
First Lord of the Admiralty and the rest of the Space Lords I would like to personally welcome you to the organization.  Please log in to <a href="https://medusa.trmn.org">MEDUSA</a> and review your contact information.  If you need to update your address or phone number, just click on the "Edit" button on the bottom of the first screen and make what ever changes are needed.</p>


<p>TRMN is a chapter based Fan Club, with local chapters playing the role of a Starship or other military unit in the Grand
Manticoran Alliance as portrayed in the Honor Harrington series of novels. You are assigned to {!!$user->getPrimaryAssignmentName()!!}. Your
commanding officer is {{App\Chapter::find($user->getPrimaryAssignmentId())->getCO()->getGreetingAndName()}}. Your commanding officer can be contacted at <a href="mailto:{{App\Chapter::find($user->getPrimaryAssignmentId())->getCO()->email_address}}">{{App\Chapter::find($user->getPrimaryAssignmentId())->getCO()->email_address}}</a>.</p>

<p>Additionally, members of the organization have three online venues:</p>


<p>The World Wide Web: <a href="http://www.trmn.org/portal/">http://www.trmn.org/portal/</a><br />
The TRMN Forums: <a href="https://forums.trmn.org">https://forums.trmn.org/</a><br />
Mailing List: <a href="http://lists.trmn.org/listinfo.cgi/trmn-trmn.org">http://lists.trmn.org/listinfo.cgi/trmn-trmn.org</a></p>


<p>The Royal Council of TRMN currently consists of five members selected and approved by David Weber to run the
organization. They include Marshal Kevin Horner – Marshal of the Royal Manticoran Army; Marshal Sean Niemeyer –
Commandant of the Royal Manticoran Marine Corps; High Admiral Thomas Saidak – High Admiral of the Grayson Space Navy;
Fleet Admiral of the Red John Roberts – First Space Lord of the Royal Manticoran Navy and Admiral of the Fleet Martin
Lessem, First Lord of the Admiralty and President of our organization.</p>

<p>Whether you are a Navigator on one of the Queen’s Starships, an Engineer
aboard one of the Protectors Own, an Oberbootsman on an Imperial Andermani Navy Battlecruiser, a Spacer of the Republic
of Haven Navy, a Marine attached to a ship’s Marine Detachment, a Soldier of the Queen’s Own, or a civilian member of
the organization, your journey has just begun.</p>

<p>Come join us in our adventure, on line, in person, or at a convention. This is now your club as much as it is ours.</p>


<p>Again, welcome to TRMN and the Honorverse.</p>

<p>In Service,</p>

<p>{{App\MedusaConfig::get('bupers.sig')}}
<a href="mailto:bupers@trmn.org">bupers@trmn.org</a></p>
</body>
</html>