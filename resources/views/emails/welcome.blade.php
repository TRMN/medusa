<!DOCTYPE html>
<html>
<body>
{!! str_replace(['%patch', '%bupers.seal%'], [$message->embed(public_path() . '/images/shoulder-patch.png'), $message->embed(public_path() . '/images/bupers.png')], \App\MedusaConfig::get('bupers.header')) !!}

{!! \App\Utility\MedusaUtility::getWelcomeLetter($user) !!}

<p>In Service,</p>

<p>{{App\MedusaConfig::get('bupers.sig')}}
    <a href="mailto:bupers@trmn.org">bupers@trmn.org</a></p>
</body>
</html>