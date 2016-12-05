<!DOCTYPE html>
<html>
<head>

    <title>Member ID</title>
    <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">

</head>
<body bgcolor="#000000">
<img src="data::image/png;base64, {{ base64_encode(QrCode::format('png')->merge("/public/images/trmn-seal.png", .2)->margin(1)->size(400)->errorCorrection('H')->generate($member_id)) }}"><br />
<a href="/home" style="color: #FFFFFF">Back</a>
</body>
</html>
