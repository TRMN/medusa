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
<p>Dear {!!$user->getGreeting()!!} {!!$user->first_name!!} {!!$user->last_name!!},</p>

<p>I have processed your transfer and I am including your old and new CO @if($user->branch == 'RMMC') as well as COMFORCECOM @endif so
    they can update their records.</p>

<table border="1">
    <tr>
        <th>Old Chapter</th>
        <th>New Chapter</th>
    </tr>
    <tr>
        <td>{!!$fromValue!!}</td>
        <td>{!!$toValue!!}</td>
    </tr>
</table>

<p>In Service,</p>

<p>{{App\Models\MedusaConfig::get('bupers.sig')}}
    <a href="mailto:bupers@trmn.org">bupers@trmn.org</a></p>

<p><em>-- <br>
        &quot;Any truly cultivated palate realizes how completely cocoa outclasses coffee as a beverage of choice.
        Anyone but a barbarian knows that&quot;<br>
        -Quote from Honor Among Enemies by David Weber</em></p>
</body>
</html>