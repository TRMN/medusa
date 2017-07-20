@extends('layout')

@section('pageTitle')
    Reset your password
@stop

@section('content')
    <div class="login-form row">
        <div class="small-6 small-centered columns">
            <h4 class="NordItalic">Reset Your Password</h4>

            <form action="{{url('/password/reset')}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                {!!Form::label('email_address', 'Your email address')!!}
                <input type="email" name="email_address" value="">
                {!!Form::label('password', "New Password")!!}
                <input type="password" name="password">
                {!!Form::label('password_confirmation', 'Renter your password')!!}
                <input type="password" name="password_confirmation">
                <input type="submit" value="Reset Password" class="button">
            </form>
        </div>
    </div>
@stop