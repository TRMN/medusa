@extends('layout')

@section('pageTitle')
    Reset your password
@stop

@section('content')
    <div class="login-form row">
        <div class="small-6 small-centered columns">
            <h4 class="NordItalic">Reset Your Password</h4>

            <p>Enter the email address you used to register and we will send you a link you can use to reset your
                password. Be sure to check your SPAM folder if you do not receive it within the next hour.</p>

            <form action="{{ url('/password/email') }}" method="POST">
                {{ Form::token() }}
                <input type="email" name="email_address" id="email_address">
                <input type="submit" value="Send Reminder" class="button">
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
