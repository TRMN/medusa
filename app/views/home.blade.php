@extends('layout')

@section('pageTitle')
Welcome
@stop

@section('content')
<h1>Welcome to the Royal Manticoran Navy!</h1>
@if( !Auth::check() )
<div class="row">
    <div class="login-form small-6 columns">
        <h2>Please Log In</h2>
        @if( count( $errors ) != 0 )
            <ul>
                @foreach( $errors as $error )
                    <li>{{{ $error }}}</li>
                @endforeach
            </ul>
        @endif
        {{ Form::open( [ 'route' => 'signin' ] ) }}
            {{ Form::label( 'email', 'Email' ) }} {{ Form::email( 'email' ) }}
            {{ Form::label( 'password', 'Password' ) }} {{ Form::password( 'password' ) }}
            {{ Form::submit( 'Sign in', [ 'class' => 'button' ] ) }}
        {{ Form::close() }}
    </div>
    <div class="small-6 columns">
        <h2>Want to Join?</h2>
        <a href="{{ URL::route( 'register' ) }}" class="button">Apply for Membership</a>
    </div>
</div>
@endif

@stop
