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
    <div class="row inset-bottom flex-vert-center navbar-fixed-top black-background header">
        <div class="col-sm-4">
            <h1 class="trmn">The Royal<br/>Manticoran Navy</h1>
        </div>


        <div class="col-sm-4 text-center">
            <h3 class="trmn">Membership Database</h3>
        </div>

        <div class="col-sm-4 text-right">
            @if(Auth::check())
                <strong>{{ Auth::user()->getGreeting() }}
                    {{ substr(Auth::user()->first_name, 0, 1) }}
                    .{{ strlen(Auth::user()->middle_name) ? ' ' . substr(Auth::user()->middle_name, 0, 1) . '. ' : ' ' }} {{ Auth::user()->last_name }}</strong>
                <h5 class="Incised901Light ninety">Last
                    Login: {!!date('d M Y @ g:i A T', strtotime(Auth::user()->getLastLogin()))!!}</h5>

                <h5 class="Incised901Light ninety" title="Accuracy is effected by the use of 'Remember Me' when logging in to the Forums">Last Forum Login:
                    @if(Auth::user()->forum_last_login)
                        {{date('d M Y @ g:i A T', Auth::user()->forum_last_login)}}
                    @else
                        Never
                    @endif
                </h5>
            @endif
        </div>

    </div>

    <div class="row">
        <div class="col-sm-2" id="left">
            @if(empty(Auth::user()->tos) === false && empty(Auth::user()->osa) === false)
                <div class="padding-top-10 padding-bottom-10">
                    <a href="{!!$serverUrl!!}"><img src="/images/trmnseal.png" alt="TRMN Seal" width="150px"
                                                    height="150px"></a>
                </div>
                @include( 'nav', ['permsObj' => $permsObj] )
            @endif
        </div>

        <div class="col-sm-10 padding-top-10 padding-bottom-10" id="right-wrapper">
            @if(Auth::check())
                <div class="btn btn-primary btn-sm toggle-nav">
                    <strong>
                        <span class="fa fa-angle-double-left size-21" id="toggle-btn"></span>
                    </strong>
                </div>

                <div class="inset-left padding-bottom-10 padding-top-10" id="right">

                @else
                    <div class="padding-bottom-10 padding-top-10" id="right">
                @endif

                    @if( $errors->any() )
                        <ul class="medusa-error">
                            @foreach( $errors->all() as $error )
                                <li class="fa fa-exclamation-triangle alert">{!! $error !!}</li>
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
                        <div class="container-fluid">
                            @yield('content')
                        </div>
                    @else

                        <div class="row padding-top-10">
                            <div class="col-sm-6 text-center">
                                <h3 class="NordItalic yellow">Sign In</h3>
                            </div>
                        </div>

                        {!! Form::open( [ 'route' => 'signin' ] ) !!}
                        {{ Form::hidden('redirect_to', Request::url()) }}
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label( 'email', 'Email' ) !!} {!! Form::email( 'email', old('email'), ['id' => 'email', 'class'=>'form-control', 'placeholder' => 'Email Address'] ) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label( 'password', 'Password' ) !!} {!! Form::password( 'password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Password'] ) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6 text-right">
                                <button class="btn btn-success btn-lg text-right Incised901Light" type="submit">Sign In
                                    <span
                                            class="fa fa-sign-in"></span></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ url('/password/reset') }}" class="text-right"><p
                                            style="font-style: italic">Forgot your password?</p></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 text-right">
                                <br clear="right">
                                <p class="text-right"><em>Not a member? Register here!</em></p>
                                <a href="{!! URL::route( 'register' ) !!}" class="btn btn-lg btn-primary text-right">Register
                                    <span class="fa fa-pencil"></span></a>
                            </div>
                        </div>
                    @endif
                </div>
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
    @if($_SERVER['SERVER_NAME'] == "medusa.dev" || $_SERVER['SERVER_NAME'] == "medusa-dev.trmn.org")
        <div class="alert alert-info text-center alert-text">
            @if($_SERVER['SERVER_NAME'] == "medusa.dev")
                LOCAL SANDBOX SERVER
            @else
                DEVELOPMENT / TEST SERVER
            @endif
        </div>
    @endif
    <span id="siteseal"><script type="text/javascript"
                                src="https://seal.starfieldtech.com/getSeal?sealID=v0CA19iS5KO2zCDMQWVQcf848PG2A4U0OWBVbTgzfEuk6Lrf8ASy84CTVQ5M"></script></span>
</footer>

<script type="text/javascript" src="{!! asset('js/vendor.js')!!}?{{ time() }}"></script>
<script src="{!! asset('js/app.js')!!}?{{ time() }}"></script>
@yield( 'scriptFooter' )
</body>
</html>
