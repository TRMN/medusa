@extends('layout')

@section('pageTitle')
    Reset your password
@stop

@section('content')
    <div class="login-form row">
        <div class="col-sm-6 small-centered ">
            <h4 class="NordItalic">Reset Your Password</h4>

            <form action="{{url('/password/reset')}}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row form-group">
                    {!!Form::label('email_address', 'Your email address', ['class' => 'control-label'])!!}
                    <input type="email" name="email_address" value="" class="form-control">
                </div>
                <div class="row form-group">
                    {!!Form::label('password', "New Password", ['class' => 'control-label'])!!}
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="row form-group">
                    {!!Form::label('password_confirmation', 'Renter your password', ['class' => 'control-label'])!!}
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="row form-group">
                    <button type="submit" class="btn btn-success"><span class="fa fa-envelope"></span> Reset Password</button>
                </div>

            </form>
        </div>
    </div>
@stop