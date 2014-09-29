<!DOCTYPE html>
<html>
<head>
    <title>@yield('pageTitle') | Royal Manticoran Navy Database</title>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/normalize.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/foundation.min.css">
    <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/main.css">

</head>
<body>

    @include('nav')

    <div class="container">
    @yield('content')
    </div>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/js/foundation.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/js/foundation/foundation.topbar.min.js"></script>
    <script>
        jQuery( document ).foundation();
    </script>
    <script src="{{{ $serverUrl }}}/js/bundle.min.js"></script>
</body>
</html>