@extends('layout')

@section('pageTitle')
    Reset your password
@stop

@section('content')
    <div class="login-form row">
        <div class="col-sm-6 small-centered ">
            <h4 class="NordItalic">Change Your Password</h4>
            @if(Auth::user()->isRequiredToChangePwd())
                <h3>You are required to change your password.
                @if(Auth::user()->getPwdAge() >= Config::get('app.max_pwd_age') &&
                    Auth::user()->forcepwd === false)
                    It has been {{ Auth::user()->getPwdAge() }} days since you changed your password.
                @endif
                </h3>
            @endif
            {!!Form::model($user, ['route' => ['user.postReset', $user->id]])!!}
            <div class="form-group">
                {!!Form::label('current_password', 'Current Password')!!}
                {!!Form::password('current_password', ['class' => 'form-control'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('password', "New Password")!!}
                {!!Form::password('password', ['class' => 'form-control'])!!}
            </div>
            <div class="form-group">
                {!!Form::label('password_confirmation', 'Renter your password')!!}
                {!!Form::password('password_confirmation', ['class' => 'form-control'])!!}
            </div>


            {!! Form::submit( 'Reset Password', [ 'class' => 'btn btn-success text-center' ] ) !!}

            {!!Form::close()!!}
        </div>
    </div>
@stop