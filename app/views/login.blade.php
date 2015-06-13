@extends('layout')

@section('pageTitle')
    Welcome!
@stop

@section('content')
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

    @if( !Auth::check() )
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
                <p style="font-style: italic">Not a member? Register here!</p>
                <a href="{{ URL::route( 'register' ) }}" class="button right reg-button">Register</a>
            </div>
        </div>
    @endif

@stop
