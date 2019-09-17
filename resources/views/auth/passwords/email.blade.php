@extends('layout')

@section('pageTitle')
    Reset your password
@stop

@section('content')
    <div class="login-form row">
        <div class="col-sm-6">
            <h1 class="NordItalic">Reset Your Password</h1>

            <p>Enter the email address you used to register and we will send you a link you can use to reset your
                password. Be sure to check your SPAM folder if you do not receive it within the next hour.</p>

            <form action="{{ url('/password/email') }}" method="POST">
                {{ Form::token() }}
                <div class="row form-group">
                    <input type="email" name="email_address" id="email_address" class="form-control">
                </div>
                <div class="row form-group">
                    <button type="submit" class="btn btn-success"><span class="fa fa-envelope"></span> Send Reminder</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('scriptFooter')
<script type="text/javascript">
    $('#email_address').on('change', function() {
        var email = $('#email_address').val();
        $('#email_address').val(email.toLowerCase());
    })
</script>
@stop