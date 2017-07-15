<!DOCTYPE html>
<html>
<head>

    <title>@yield('pageTitle') | Royal Manticoran Navy Database</title>
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
    @yield('dochead')
</head>
<body class="@yield('bodyclasses')">
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
        @if(empty(Auth::user()->tos) === FALSE && empty(Auth::user()->osa) === FALSE)
            <div class="small-2 columns trmn-width">
                @include( 'nav', ['permsObj' => $permsObj] )
            </div>
        @endif
        <div class="small-10 columns trmn-width content">
            @if( $errors->any() )
                <ul class="medusa-error">
                    @foreach( $errors->all() as $error )
                        <li class="fi-alert alert">{!! $error !!}</li>
                    @endforeach
                </ul>
            @endif

            @if(Session::has('message'))
                <p>{!!Session::get('message')!!}</p>
            @endif
            @if(!empty($message))
                <p>{!!$message!!}</p>
            @endif
            @if(Auth::check() ||
                in_array(\Route::currentRouteName(),[
                    'user.apply',
                    'register',
                    'osa',
                ]) || \Request::is('password/*') )
                @yield('content')
            @else
                <div class="login-form row">
                    <div class="small-6 small-centered columns">
                        <h4 class="NordItalic">Sign In</h4>
                        {!! Form::open( [ 'route' => 'signin' ] ) !!}
                        {!! Form::label( 'email', 'Email' ) !!} {!! Form::email( 'email' ) !!}
                        {!! Form::label( 'password', 'Password' ) !!} {!! Form::password( 'password' ) !!}
                        {!! Form::submit( 'Sign in', [ 'class' => 'button right reg-button' ] ) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

                    <div class="row">
                        <div class="small-6 small-centered columns">
                            <a href="{{ url('/password/reset') }}" class="right"><p
                                        style="font-style: italic">Forgot your password?</p></a>
                        </div>
                    </div>

                <div class="row">
                    <div class="small-6 small-centered columns">
                        <p style="font-style: italic" class="right">Not a member? Register here!</p><br clear="right">
                        <a href="{!! URL::route( 'register' ) !!}" class="button right reg-button">Register</a>
                    </div>
                </div>
            @endif
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
@yield( 'scriptFooter' )
</body>
</html>
