<!DOCTYPE html>
<html>
<head>
    <title>@yield('pageTitle') | Royal Manticoran Navy Database</title>
    <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/main.css">
    <script src="{{{ $serverUrl }}}/js/bundle.min.js"></script>
</head>
<body>

@include('nav')

<div class="container">
@yield('content')
</div>

</body>
</html>