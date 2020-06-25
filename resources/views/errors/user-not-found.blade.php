<!DOCTYPE html>
<html>
<head>
    <title>User or Chapter not found | Royal Manticoran Navy Database</title>
    <META HTTP-EQUIV="cache-control" CONTENT="no-cache">
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/v/bs/dt-1.10.16/sc-1.4.3/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="{!! asset('css/vendor.css') !!}?{{ time() }}">
        <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}?{{ time() }}">
        <link rel="stylesheet" type="text/css" href="{!! asset('css/overrides.css') !!}?{{ time() }}">
        <link href="https://fonts.googleapis.com/css?family=Volkhov" rel="stylesheet">

        <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">
        @yield('dochead')
        </head>
<body>
<div class="container-fluid">
    <div class="row inset-bottom flex-vert-center navbar-fixed-top black-background header">
        <div class="col-sm-4 text-nowrap">
            <h1 class="trmn">The Royal<br/>Manticoran Navy</h1>
        </div>


        <div class="col-sm-4 text-center">
            <h3 class="trmn roster-narrow-1160 roster-narrow-1045">Membership Database</h3>
        </div>

        <div class="col-sm-4 text-right text-nowrap">
            @if(Auth::check())
                <a href="/home" title="Return to your Service Record">
                    <strong>{{ Auth::user()->getGreeting() }}
                        {{ substr(Auth::user()->first_name, 0, 1) }}
                        .{{ strlen(Auth::user()->middle_name) ? ' ' . substr(Auth::user()->middle_name, 0, 1) . '. ' : ' ' }} {{ Auth::user()->last_name }}</strong></a>
                <h5 class="Incised901Light ninety">Last
                    Login: {!!date('d M Y @ g:i A T', strtotime(Auth::user()->getLastLogin()))!!}</h5>

                <h5 class="Incised901Light ninety"><span class="fa fa-exclamation-triangle yellow" data-toggle="tooltip"
                                                         data-placement="bottom"
                                                         title="Accuracy is effected by the use of 'Remember Me' when logging in to the Forums"></span>&nbsp;Last
                    Forum
                    Login:
                    @if(Auth::user()->forum_last_login)
                        {{date('d M Y @ g:i A T', Auth::user()->forum_last_login)}}
                    @else
                        Never
                    @endif
                </h5>
            @endif
        </div>

    </div>

    <div class="row ">
        <div class="col-sm-12 text-center">
            <div class="padding-top-10 padding-bottom-10 float-left">
                <a href="{!!$serverUrl!!}"><img src="/images/trmn-seal.png" alt="TRMN Seal" width="150px"
                                                height="150px"></a>
            </div>
            <h2>&ldquo;I'm dreadfully sorry, Your Grace, but it simply won't be possible.</h2>

            <h3>The officers you requested are currently unavailable for assignment at this time.&rdquo;</h3>
            <p>&nbsp;</p>

            <p class="text-center"><strong>Ok, ok. We couldn't find the member or chapter you were looking
                    for... </strong></p>
            <p><a href="/home" class="btn btn-lg btn-primary">Return to the main page</a></p>
        </div>
    </div>
</div>
<footer class="inset-top">
    <p>Copyright &copy; 2008 &ndash; {!! date('Y') !!} The Royal Manticoran Navy: The Official Honor Harrington Fan
        Association,
        Inc. Some Rights Reserved.
        Honor Harrington and all related materials are &copy; David Weber.</p>
    <span class="text-center"><img src="{!!asset('images/project-medusa.svg')!!}" width="150px" height="150px"
                                   data-src="{!!asset('images/project-medusa.svg')!!}"></span>
    <p>{!! Config::get('app.version') !!}</p>
    @if(in_array($_SERVER['SERVER_NAME'],  ["medusa.dev", "medusa-dev.trmn.org", "medusa.local", "localhost"]))
        <div class="alert alert-info text-center alert-text">
            @if($_SERVER['SERVER_NAME'] == "medusa-dev.trmn.org")
                DEVELOPMENT / TEST SERVER
            @else
                LOCAL SANDBOX SERVER
            @endif
        </div>
    @endif
    <span id="siteseal"><script type="text/javascript"
                                src="https://seal.starfieldtech.com/getSeal?sealID=v0CA19iS5KO2zCDMQWVQcf848PG2A4U0OWBVbTgzfEuk6Lrf8ASy84CTVQ5M"></script></span>
</footer>
<script type="text/javascript" src="{!! asset('js/vendor.js')!!}?{{ time() }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/sc-1.4.3/datatables.min.js"></script>

<script src="{!! asset('js/app.js')!!}?{{ time() }}"></script>
@yield( 'scriptFooter' )
</body>
