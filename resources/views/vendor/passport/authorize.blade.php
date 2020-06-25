<!DOCTYPE html>
<html>
<head>

    <title>Authorization Request From {!!$client->name!!} | Royal Manticoran Navy Database</title>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/vendor.css') !!}?{{ time() }}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}?{{ time() }}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/overrides.css') !!}?{{ time() }}">
    <link rel="shortcut icon" href="{!! asset('favicon.ico') !!}">
</head>
<body>
<div class="container">

    @if(Auth::check())
        <div class="row text-center">
            <div class=" col-sm-3">&nbsp;</div>
            <div class=" col-sm-2 text-center">
                <img src="{!!asset('images/project-medusa.svg')!!}" width="150px" height="150px">
            </div>
            <div class=" col-sm-4 Incised901Light">
                <h3>An application would like to connect to your account</h3>
            </div>
            <div class=" col-sm-3">&nbsp;</div>
        </div>
        <div class="row">
            <div class=" col-sm-3">&nbsp;</div>
            <div class=" col-sm-6 Incised901Light">
                <p><br/>The application <span class="Incised901Bold">{!!$client->name!!}</span> wants to access
                    your basic information (name, email address, city, state/province, country and your profile
                    picture).
                </p>
            </div>
            <div class=" col-sm-3">&nbsp;</div>
        </div>
        <div class="row">
            <div class=" col-sm-3">&nbsp;</div>
            <div class=" col-sm-6 Incised901Light text-center">
                <h3>Allow <span class="Incised901Bold">{!!$client->name!!}</span> access?</h3>
            </div>
            <div class=" col-sm-3">&nbsp;</div>
        </div>
        <div class="row">
            <div class=" col-sm-3">&nbsp;</div>
            <div class=" col-sm-3 Incised901Light text-center">
                <form method="post" action="/oauth/authorize">
                    {{ csrf_field() }}

                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                    <button type="submit" class="btn">Approve</button>
                </form>
            </div>
            <div class=" col-sm-3 Incised901Light text-center">
                <form method="post" action="/oauth/authorize">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                    <button class="btn">Deny</button>
                </form>
            </div>
            <div class=" col-sm-3">&nbsp;</div>
        </div>
    @else
        <div class="login-form row">
            <div class=" col-sm-3">&nbsp;</div>
            <div class="col-sm-6 small-centered ">
                <h4 class="NordItalic">Sign In</h4>
                {!! Form::open( [ 'route' => 'signin' ] ) !!}
                {!! Form::label( 'email', 'Email' ) !!} {!! Form::email( 'email' ) !!}
                {!! Form::label( 'password', 'Password' ) !!} {!! Form::password( 'password' ) !!}
                {!! Form::submit( 'Sign in', [ 'class' => 'btn right reg-button' ] ) !!}
                {!! Form::close() !!}
            </div>
            <div class=" col-sm-3">&nbsp;</div
        </div>


        <div class="row">
            <div class=" col-sm-3">&nbsp;</div>
            <div class="col-sm-6 small-centered ">
                <p style="font-style: italic" class="right">Not a member? Register here!</p><br clear="right">
                <a href="{!! URL::route( 'register' ) !!}" class="btn right reg-button">Register</a>
            </div>
            <div class=" col-sm-3">&nbsp;</div>
        </div>
    @endif


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
</div>
</body>
</html>

