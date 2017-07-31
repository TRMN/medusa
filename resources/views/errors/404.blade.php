<!DOCTYPE html>
<html>
<head>

    <title>Dutchman! (Page not found) | Royal Manticoran Navy Database</title>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/normalize.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/foundation.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/jquery.ui.datepicker.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/jquery.dataTables.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/dataTables.foundation.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/dataTables.jqueryui.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/jquery-ui.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/selectize.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/main.css') !!}">
    <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">
</head>
<body>
<div class="container">
    <header class="row trmn-width">

        <div class="small-2 columns trmn-width">
            <p></p><a href="{!!$serverUrl!!}"><img src="/images/trmnseal.png" alt="TRMN Seal" width="150px"
                                                   height="150px"></a>
        </div>
        <div class="small-10 columns trmn-width end">
            <h1 class="trmn">The Royal<br/>Manticoran Navy</h1>

            <h3 class="trmn">Membership Database</h3>
        </div>
    </header>
    <div class="row trmn-width">
        <div class="small-12 columns trmn-width">
            <h2>Dutchman! Dutchman! Flight Ops is declaring a Dutchman! Get the ready pinnace out now!</h2>

            <p><em>CIC</em></p>

            <p>Listen up! I've got a Dutchman headed away from the ship at thirty-five gees. I painted the trace on your
                plot
                three minutes ago. Tie in to the ready pinnace and guide them in on it &mdash; and for God's sake, don't
                lose it!</p>

            <p><em>Acknowledged!</em></p>

            <p class="text-center"><strong>Ok, ok. We couldn't find the page you were looking for....</strong></p>
        </div>
    </div>
</div>
<footer>
    <p>Copyright &copy; 2008 &ndash; {!! date('Y') !!} The Royal Manticoran Navy: The Official Honor Harrington Fan
        Association,
        Inc. Some Rights Reserved.
        Honor Harrington and all related materials are &copy; David Weber.</p>
    <span class="text-center"><img src="{!!asset('images/project-medusa.svg')!!}" width="150px" height="150px"
                                   data-src="{!!asset('images/project-medusa.svg')!!}"></span>
    <p>{!! Config::get('app.version') !!}</p>
    @if($_SERVER['SERVER_NAME'] == "medusa.dev" || $_SERVER['SERVER_NAME'] == "medusa-dev.trmn.org")
        <p class="alert-box">
            @if($_SERVER['SERVER_NAME'] == "medusa.dev")
                LOCAL SANDBOX SERVER
            @else
                DEVELOPMENT / TEST SERVER
            @endif
        </p>
    @endif
    <span id="siteseal"><script type="text/javascript"
                                src="https://seal.starfieldtech.com/getSeal?sealID=v0CA19iS5KO2zCDMQWVQcf848PG2A4U0OWBVbTgzfEuk6Lrf8ASy84CTVQ5M"></script></span>
</footer>

<script type="text/javascript" src="{!! asset('js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/foundation.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/foundation.topbar.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/foundation.accordion.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/foundation.reveal.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery-ui.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.dataTables.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/dataTables.foundation.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/dataTables.jqueryui.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.autocomplete.js')!!}"></script>
<script type="text/javascript" src="{!! asset('js/selectize.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.multipage.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/js.cookie.js') !!}"></script>
<script>
    jQuery(document).foundation();
</script>
<script src="{!! asset('js/rcswitcher.js')!!}"></script>
<script src="{!! asset('js/bundle.js')!!}"></script>
</body>
