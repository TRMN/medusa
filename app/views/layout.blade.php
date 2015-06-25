<!DOCTYPE html>
<html>
<head>

    <title>@yield('pageTitle') | Royal Manticoran Navy Database</title>
    @if(App::environment('local') === true)
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/normalize.min.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/foundation.min.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/jquery.ui.datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/dataTables.foundation.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/dataTables.jqueryui.css">
        <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/jquery-ui.css">
    @else
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/normalize.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/foundation.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery.ui.datepicker.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdn.datatables.net/plug-ins/1.10.7/integration/foundation/dataTables.foundation.css">
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.css">

    @endif
    <link rel="stylesheet" type="text/css" href="{{{ $serverUrl }}}/css/main.css">

</head>
<body class="@yield('bodyclasses')">
<div class="container">
    <header class="row trmn-width">

        <div class="small-2 columns trmn-width">
            <p></p><a href="{{{$serverUrl}}}"><img src="{{{$serverUrl}}}/images/trmn-seal.png" alt="TRMN Seal"></a>
        </div>
        <div class="small-10 columns trmn-width end">
            <h1 class="trmn">The Royal<br/>Manticoran Navy</h1>

            <h3 class="trmn">Membership Database</h3>
        </div>
    </header>

    <div class="row trmn-width">
        <div class="small-2 columns trmn-width">
            @include( 'nav' )
        </div>
        <div class="small-9 columns trmn-width content end">
            @yield( 'content' )
        </div>
    </div>

    <footer class="row">
        <p>Copyright &copy; 2008 &ndash; {{{ date('Y') }}} The Royal Manticoran Navy: The Official Honor Harrington Fan
            Association,
            Inc. Some Rights Reserved.
            Honor Harrington and all related materials are &copy; David Weber.</p>

        <p>Medusa Version {{{ Config::get('app.version') }}}</p>
    </footer>
</div>
@if(App::environment('local') === true)
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/foundation.min.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/foundation.topbar.min.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/foundation.accordion.min.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/foundation.reveal.min.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/dataTables.foundation.js"></script>
    <script type="text/javascript" src="{{{ $serverUrl }}}/js/dataTables.jqueryui.js"></script>
@else
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/js/foundation.min.js"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/foundation/foundation.topbar.min.js"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/foundation/foundation.accordion.min.js"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/foundation/foundation.reveal.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="javascript"
            src="//cdn.datatables.net/plug-ins/1.10.7/integration/foundation/dataTables.foundation.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.js"></script>
@endif
<script>
    jQuery(document).foundation();
</script>
<script src="{{{ $serverUrl }}}/js/bundle.js"></script>
@yield( 'scriptFooter' )
</body>
</html>
