<!DOCTYPE html>
<html>
<head>

    <title>Manticoran Enhanced Data Usability System Architecture</title>
    @if(App::environment('local') === true)
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/normalize.min.css">
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/foundation.min.css">
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/jquery.ui.datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/dataTables.foundation.css">
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/dataTables.jqueryui.css">
        <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/jquery-ui.css">
    @else
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/normalize.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/foundation.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery.ui.datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
              href="//cdn.datatables.net/plug-ins/1.10.7/integration/foundation/dataTables.foundation.css">
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"
        <link rel="stylesheet" type="text/css"
              href="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.css">

    @endif
    <link rel="stylesheet" type="text/css" href="{{ $serverUrl }}/css/main.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>
<body id="down">
<div style="width: 100%; float: left">
    <div class="row">
        <div class="columns small-12 Incised901Black"><br />Thank you for joining The Royal Manticoran Navy: The Official Honor Harrington Fan Association.  Your application will be reviewed and you should receive an email in 48 to 72 hours once your account has been activated. <strong>You will not be able to log in to MEDUSA until you have received your welcome email.</strong><br /><br /></div>
    </div>
    <div class="row">
        <div class="columns small-12 text-center"><img src="{{asset('seals/RMN.svg')}}" width="50%" height="50%"/></div>
    </div>
    <div class="row">
        <div class="columns small-12 Incised901Bold"><br /><em>Thank you for your interest in The Royal Manticoran Navy: The Official Honor Harrington Fan Association.  Welcome Aboard!</em></div>
    </div>
</div>
@if(App::environment('local') === true)
    <script type="text/javascript" src="{{ $serverUrl }}/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/foundation.min.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/foundation.topbar.min.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/foundation.accordion.min.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/foundation.reveal.min.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/dataTables.foundation.js"></script>
    <script type="text/javascript" src="{{ $serverUrl }}/js/dataTables.jqueryui.js"></script>
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
    <script type="text/javascript"
            src="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.js"></script>
@endif
<script>
    jQuery(document).foundation();
</script>
<script src="{{ $serverUrl }}/js/rcswitcher.js"></script>
<script src="{{ $serverUrl }}/js/bundle.js"></script>
</body>
</html>