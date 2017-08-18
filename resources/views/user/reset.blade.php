@extends('layout')

@section('pageTitle')
    Reset your password
@stop

@section('content')
    <div class="login-form row">
        <div class="col-sm-6 small-centered ">
            <h4 class="NordItalic">Change Your Password</h4>

            {!!Form::model($user, ['route' => ['user.postReset', $user->id]])!!}
                {!!Form::label('current_password', 'Current Password')!!}
                {!!Form::password('current_password')!!}

                {!!Form::label('password', "New Password")!!}
                {!!Form::password('password')!!}

                {!!Form::label('password_confirmation', 'Renter your password')!!}
                {!!Form::password('password_confirmation')!!}

                {!! Form::submit( 'Reset Password', [ 'class' => 'btn' ] ) !!}

            {!!Form::close()!!}
        </div>
    </div>
@stop