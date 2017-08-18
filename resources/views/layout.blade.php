<!DOCTYPE html>
<html>
<head>

    <title>@yield('pageTitle') | Royal Manticoran Navy Database</title>
    <META HTTP-EQUIV="cache-control" CONTENT="no-cache">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/vendor.css') !!}?{{ time() }}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}?{{ time() }}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/overrides.css') !!}?{{ time() }}">
    <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">
    @yield('dochead')
</head>
<body class="@yield('bodyclasses')">
<div class="container-fluid">

        <div class="row margin-5">
            <div class="col-sm-2">
                <p></p><a href="{!!$serverUrl!!}"><img src="/images/trmnseal.png" alt="TRMN Seal" width="150px"
                                                       height="150px"></a>
            </div>
            <div class="col-sm-10">
                <h1 class="trmn">The Royal<br/>Manticoran Navy</h1>

                <h3 class="trmn">Membership Database</h3>
            </div>
        </div>


    <div class="row">
        @if(empty(Auth::user()->tos) === false && empty(Auth::user()->osa) === false)
            <div class="col-sm-2">
                @include( 'nav', ['permsObj' => $permsObj] )
            </div>
        @endif
        <div class="col-sm-10 content">
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

            @if(Session::has('status'))
                <p>{!!Session::get('status')!!}</p>
            @endif

            @if(!empty($message))
                <p>{!!$message!!}</p>
            @endif
            @if(Auth::check() ||
                in_array(\Route::currentRouteName(),[
                    'user.apply',
                    'register',
                    'osa',
                    'tos.noauth',
                ]) || \Request::is('password/*') )
                @yield('content')
            @else
                <div class="login-form row">
                    <div class="col-sm-6 small-centered ">
                        <h4 class="NordItalic">Sign In</h4>
                        {!! Form::open( [ 'route' => 'signin' ] ) !!}
                        {{ Form::hidden('redirect_to', Request::url()) }}
                        {!! Form::label( 'email', 'Email' ) !!} {!! Form::email( 'email' ) !!}
                        {!! Form::label( 'password', 'Password' ) !!} {!! Form::password( 'password' ) !!}
                        {!! Form::submit( 'Sign in', [ 'class' => 'btn right reg-button' ] ) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 small-centered ">
                        <a href="{{ url('/password/reset') }}" class="right"><p
                                    style="font-style: italic">Forgot your password?</p></a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 small-centered ">
                        <p style="font-style: italic" class="right">Not a member? Register here!</p><br clear="right">
                        <a href="{!! URL::route( 'register' ) !!}" class="btn right reg-button">Register</a>
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
        <p class="alert">
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

<script type="text/javascript" src="{!! asset('js/vendor.js')!!}?{{ time() }}"></script>
<script src="{!! asset('js/app.js')!!}?{{ time() }}"></script>
@yield( 'scriptFooter' )
</body>
</html>
