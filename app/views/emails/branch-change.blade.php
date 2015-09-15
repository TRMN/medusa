<!DOCTYPE html>
<html>
<body>
<table border="0">
    <tr>
        <td valign="middle"><img src="{{$message->embed(public_path() . '/images/shoulder-patch.png')}}"
                                 alt="Rampant Manticore"/></td>
        <td valign="middle" align="center"><h2>THE ROYAL MANTICORAN NAVY<br/>OFFICE OF THE FIFTH SPACE LORD<br/>BUREAU
                OF PERSONNEL<br/>ADMIRALTY HOUSE<br/>LANDING</h2></td>
        <td valign="middle"><img src="{{$message->embed(public_path() . '/images/bupers.png')}}" alt="BuPers"/></td>
    </tr>
</table>
<p>Dear {{$user->getGreeting()}} {{$user->first_name}} {{$user->last_name}},</p>

<p>I have processed your branch change and I am including your CO@if($user->branch == 'RMMC') and COMFORCECOM@endif so they can update their records.</p>

<table border="0">
    <tr>
        <th>Old Branch</th>
        <th>New Branch</th>
    </tr>
    <tr>
        <td>{{$fromValue}}</td>
        <td>{{$toValue}}</td>
    </tr>
</table>

<p>Lt. Colonel Mark Morgan<br>
Chief of Staff<br>
5th Space Lord, Bureau of Personnel - TRMN<br><br>
"Possimus Perficio!"
</p>
</body>
</html>