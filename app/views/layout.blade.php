<!DOCTYPE html>
<html>
<head>

    <title>@yield('pageTitle') | Royal Manticoran Navy Database</title>
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
@yield('dochead')
</head>
<body class="@yield('bodyclasses')">
<div class="container">
    <header class="row trmn-width">

        <div class="small-2 columns trmn-width">
            <p></p><a href="{{$serverUrl}}"><img src="{{$serverUrl}}/seals/RMN.png" alt="TRMN Seal" width="150px" height="150px"></a>
        </div>
        <div class="small-10 columns trmn-width end">
            <h1 class="trmn">The Royal<br/>Manticoran Navy</h1>

            <h3 class="trmn">Membership Database</h3>
        </div>
    </header>

    <div class="row trmn-width">
        @if(empty(Auth::user()->tos) === false && empty(Auth::user()->osa) === false)
        <div class="small-2 columns trmn-width">
            @include( 'nav', ['permsObj' => $permsObj] )
        </div>
        @endif
        <div class="small-9 columns trmn-width content end">
            @if( $errors->any() )
                <ul class="errors">
                    @foreach( $errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @if(Session::has('message'))
                <p>{{Session::get('message')}}</p>
            @endif
            @if(Auth::check() ||
                in_array(\Route::currentRouteName(),[
                    'user.apply',
                    'register'
                ]) ||
                in_array(Route::currentRouteAction(), [
                    'RemindersController@getRemind',
                    'RemindersController@postRemind',
                    'RemindersController@getReset',
                    'RemindersController@postReset'
                ]))
            @yield('content')
            @else
                <div class="login-form row">
                    <div class="small-6 small-centered columns">
                        <h4 class="NordItalic">Sign In</h4>
                        {{ Form::open( [ 'route' => 'signin' ] ) }}
                        {{ Form::label( 'email', 'Email' ) }} {{ Form::email( 'email' ) }}
                        {{ Form::label( 'password', 'Password' ) }} {{ Form::password( 'password' ) }}
                        {{ Form::submit( 'Sign in', [ 'class' => 'button right reg-button' ] ) }}
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 small-centered columns">
                        <a href="{{ action('RemindersController@getRemind') }}" class="right"><p
                                    style="font-style: italic">Forgot your password?</p></a>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 small-centered columns">
                        <p style="font-style: italic" class="right">Not a member? Register here!</p><br clear="right">
                        <a href="{{ URL::route( 'register' ) }}" class="button right reg-button">Register</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <footer class="row">
        <p>Copyright &copy; 2008 &ndash; {{ date('Y') }} The Royal Manticoran Navy: The Official Honor Harrington Fan
            Association,
            Inc. Some Rights Reserved.
            Honor Harrington and all related materials are &copy; David Weber.</p>

        <p>{{ Config::get('app.version') }}</p>
        <span id="siteseal"><script type="text/javascript"
                                    src="https://seal.starfieldtech.com/getSeal?sealID=v0CA19iS5KO2zCDMQWVQcf848PG2A4U0OWBVbTgzfEuk6Lrf8ASy84CTVQ5M"></script></span>
    </footer>
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
@yield( 'scriptFooter' )
</body>
</html>
