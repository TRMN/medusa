@extends('layout')

@section('pageTitle')
    Welcome!
@stop

@section('content')
    @guest
        <div class="login-form row">
            <div class="col-sm-6 small-centered ">
                <h4 class="NordItalic">Sign In</h4>
                {!! Form::open( [ 'route' => 'signin' ] ) !!}
                {!! Form::label( 'email', 'Email' ) !!} {!! Form::email( 'email' ) !!}
                {!! Form::label( 'password', 'Password' ) !!} {!! Form::password( 'password' ) !!}
                {!! Form::submit( 'Sign in now', [ 'class' => 'btn right reg-button' ] ) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 small-centered ">
                <a href="{{ route('password.request') }}" class="right"><p
                            style="font-style: italic">Forgot your password dummy?</p></a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 small-centered ">
                <p style="font-style: italic" class="right">Not a member? Register here!</p><br clear="right">
                <a href="{!! URL::route( 'register' ) !!}" class="btn right reg-button">Register</a>
            </div>
        </div>
    @endguest

@stop
