<!DOCTYPE html>
<html>
<body>
<table border="0">
    <tr>
        <td valign="middle"><img src="{!!$message->embed(public_path() . '/images/shoulder-patch.png')!!}" alt="Rampant Manticore" /></td>
        <td valign="middle" align="center"><h2>THE ROYAL MANTICORAN NAVY<br />OFFICE OF THE FIFTH SPACE LORD<br />BUREAU OF PERSONNEL<br/>ADMIRALTY HOUSE<br/>LANDING</h2></td>
        <td valign="middle"><img src="{!!$message->embed(public_path() . '/images/bupers.png')!!}" alt="BuPers" /></td>
    </tr>
</table>

<p>Greetings and welcome to The Royal Manticoran Navy: The Official Honor Harrington Fan Association (TRMN).</p>

<p>I am Admiral Stephanie Taylor (RMN), Fifth Space Lord and head of the Bureau of Personnel (BuPers). I would like to
    personally welcome you to the organization. A temporary ID card will be forthcoming via email shortly. All other
    membership information can be found via the website <a href="http://www.trmn.org">http://www.trmn.org</a> you can
    also log in to your account from the member DB login screen. I do want to make sure I have the right address on file.
    The following is the address I currently have for you:</p>

<p><br>
    RMN ID: {!!$user->member_id!!}<br>
    Name: {!!$user->first_name!!} {!!$user->last_name!!}<br>
    Address: {!!$user->address1!!}<br>
    @if(!empty($user->address2))
    Address: {!!$user->address2!!}<br>
    @endif
    City: {!!$user->city!!}<br>
    State: {!!$user->state_province!!}<br>
    Zip/Postal Code: {!!$user->postal_code!!} <br>
    Country: {!!$user->country!!}<br>
    @if(!empty($user->phone_number))
    Phone: {!!$user->phone_number!!}<br>
    @endif
    Branch: {!!$user->branch!!}<br>
    Email: {!!$user->email_address!!}<br>
    @if(!empty($user->dob))
    Birthday: {!!$user->dob!!}<br>
    @endif
    Rank: {!!$user->getGreeting()!!}<br>
    <br>
    You are currently assigned to the {!!$user->getPrimaryAssignmentName()!!}. To learn about our Chapters, visit the
    Berthing Registry at: <a href="http://is.gd/9uhAib">http://is.gd/9uhAib</a></p>

<p>Be sure to check out our main Facebook group at <a href="https://www.facebook.com/groups/TRMN.ORG/">https://www.facebook.com/groups/TRMN.ORG/</a>
    and our announcements group, where announcements and the latest news is shared, at
    <a href="https://www.facebook.com/groups/trmnannounce/">https://www.facebook.com/groups/trmnannounce/</a></p>

<p>Admiral James Friedline is in charge of the Bureau of Training (BuTrain). BuTrain provides training for all the
    branches of the TRMN. There is the Saganami Island Naval Academy which includes specialized technical training, the
    Enlisted Academy, Warrant Academy, Officer's Academy and War College. The SIA is also where the Marine Academy is
    located. You can also find the King Roger I Military Academy for the Royal Manticoran Army, Landing University for
    our Civilian members, and the Sphinx Forestry Service for our younger members.</p>

<p>It is important to understand that your academic record is tied directly to you opportunities for promotion within
    the TRMN. For more information on this, find the BuTrain manual online at the TRMN website under Documents. You can
    apply online for the exams you need by going to the TRMN website - under the drop down menu for 'Academies'. Click
    on 'Course Request Form,' then select the appropriate Academy based on your branch of service. You start at the
    Enlisted level and proceed from there. The prerequisite for each course is listed on the description page of the
    website.</p>

<p>Make sure to fill out the Student Information section of the Course Request Form, including email address and
    membership number...yours is listed above.</p>

<p>You'll also need to fill out the Student Information section, including email address and membership number... yours
    is listed above. If you have any academy-related questions, contact Admiral Friedline at <a href="mailto:butrain@trmn.org">butrain@trmn.org</a></p>

<p>If you have any other membership-related questions, please let me or the Admiralty know.</p>

<p>Again, welcome to TRMN and the Honorverse.</p>

<p>In Service,</p>

<p>Rear Admiral of the Red<br>
    Stephanie Taylor SC GS<br>
    5th Space Lord, BuPersonnel - TRMN<br />
    <a href="mailto:bupers@trmn.org">bupers@trmn.org</a></p>

<p><em>-- <br>
        &quot;Any truly cultivated palate realizes how completely cocoa outclasses coffee as a beverage of choice.
        Anyone but a barbarian knows that&quot;<br>
        -Quote from Honor Among Enemies by David Weber</em></p>


</body>
</html>