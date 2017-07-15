@extends('layout')

@section('pageTitle')
    Welcome!
@stop

@section('content')
    @if( !Auth::check() )
        <div class="login-form row">
            <div class="small-6 small-centered columns">
                <h4 class="NordItalic">Sign In</h4>
                {!! Form::open( [ 'route' => 'signin' ] ) !!}
                {!! Form::label( 'email', 'Email' ) !!} {!! Form::email( 'email' ) !!}
                {!! Form::label( 'password', 'Password' ) !!} {!! Form::password( 'password' ) !!}
                {!! Form::submit( 'Sign in now', [ 'class' => 'button right reg-button' ] ) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="small-6 small-centered columns">
                <a href="{!! action('RemindersController@getRemind') !!}" class="right"><p
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

@stop
