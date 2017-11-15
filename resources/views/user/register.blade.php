@extends( 'layout' )

@section( 'pageTitle' )
Membership Application
@stop

@section('dochead')
<script src='https://www.google.com/recaptcha/api.js'></script>
@stop

@section( 'bodyclasses' )
registerform
@stop

@section( 'content' )
    <h1>Membership Application</h1>

    {!! Form::model( $user, [ 'route' => [ 'user.apply' ], 'id' => 'register' ] ) !!}

    <h2>The Basics</h2>
    <fieldset>
        <legend>You'll use your email address and password to log in to the site</legend>

        <div class="row">
            <div class="col-sm-6 form-group">
                {!! Form::label( 'email_address', 'Email', null, ['class' => 'control-label'] ) !!} {!! Form::email( 'email_address', null, ['class' => 'form-control'] ) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 form-group">
                {!! Form::label( 'password', 'Password', null, ['class' => 'control-label'] ) !!} {!! Form::password( 'password', ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-6 form-group">
                {!! Form::label( 'password_confirmation', 'Confirm Password', null, ['class' => 'control-label'] ) !!} {!! Form::password( 'password_confirmation', ['class' => 'form-control'] ) !!}
            </div>
        </div>
    </fieldset>

    <h2>Name</h2>
    <fieldset>
        <legend>We need to know what to call you</legend>

        <div class="row">
            <div class="col-sm-4  form-group">
                {!! Form::label( 'first_name', 'First Name', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'first_name', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-3  form-group">
                {!! Form::label( 'middle_name', 'Middle Name', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'middle_name', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-4  form-group">
                {!! Form::label( 'last_name', 'Last Name', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'last_name', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-1  form-group">
                {!! Form::label( 'suffix', 'Suffix', null, ['class' => 'control-label'] ) !!} {!! Form::select('suffix', ['' => 'None', 'Jr' => 'Jr', 'Sr' => 'Sr', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', 'V' => 'V'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </fieldset>

    <h2>Address</h2>

    <fieldset>
        <legend>We only use this to help place you in the right chapter. We won't share this with anyone outside of the
            organization.
        </legend>

        <div class="row">
            <div class="col-sm-6  form-group">
                {!! Form::label( 'address1', 'Street Address', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'address1', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-6  form-group">
                {!! Form::label( 'address2', 'Address Line 2', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'address2', null, ['class' => 'form-control'] ) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3  form-group">
                {!! Form::label( 'city', 'City', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'city', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-3  form-group">
                {!! Form::label( 'state_province', 'State/Province', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'state_province', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-3  form-group">
                {!! Form::label( 'postal_code', 'Zip/Postal Code', null, ['class' => 'control-label'] ) !!} {!! Form::text( 'postal_code', null, ['class' => 'form-control'] ) !!}
            </div>
            <div class="col-sm-3  form-group">
                {!! Form::label( 'country', 'Country', null, ['class' => 'my'] ) !!} {!! Form::select( 'country', $countries, null, ['class' => 'selectize'] ) !!}
            </div>
        </div>
    </fieldset>

    <h2>Age Verification</h2>
    <fieldset>
        <legend>We only use this to verify your eligibility for certain leadership positions</legend>
        <div class="col-sm-6 form-group">
            {!! Form::label('dob', 'Date of Birth', null, ['class' => 'control-label']) !!} {!!Form::date('dob', null, ['class' => 'form-control'])!!}
        </div>
    </fieldset>

    <h2>Branch</h2>

    <fieldset>
        <legend>Please choose which branch you would like to be part of</legend>
        <div class="row">
            <div class="col-sm-6 form-group">
                {!! Form::label( 'branch', "Branch", null, ['class' => 'control-label']) !!} {!! Form::select( 'branch', $branches, null, ['class' => 'form-control'] ) !!}
            </div>
        </div>
    </fieldset>

    <h2>Chapter</h2>
    <fieldset>
        <legend>Please choose what chapter you would like to join</legend>
        <div class="row">
            <div class="col-sm-12 form-group">
                <p>If you're not sure, choose one of the holding
                    chapters. You may join any chapter, regardless of your branch</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                {!! Form::label( 'primary_assignment', "Chapter", null, ['class' => 'control-label']) !!} {!! Form::select( 'primary_assignment', $chapters, null, ['class' => 'selectize'] ) !!}
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Terms of Service</legend>
        <div class="row">
            <div class="col-sm-12 text-left">
                <em><strong>I have read and agree to the <a href="#" data-target="#tos" data-toggle="modal">Terms of Service</a></strong></em>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-left">
                No <label class="switch">
                    <input type="checkbox" name="tos" value="1" id="tosAgree">
                    <span class="slider round"></span>
                </label> Yes
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Please prove that you're a sentient being</legend>
        <div class="row">
            <div class="col-sm-4  ">
                <div class="g-recaptcha" data-sitekey="{{config('recaptcha.public')}}"></div>
            </div>
        </div>
    </fieldset>
    {!! Form::submit( 'Sign me up!', [ 'class' => 'btn btn-success', 'disabled' => true, 'id' => 'btnSubmit' ] ) !!}

    {!! Form::close() !!}

    <div id="tos" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-title">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="text-center">Terms of Service</h4>
                </div>
                <div class="modal-body">
                    @include('partials.tos')
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span class="fa fa-times"></span> <storng>Close</storng> </button>
                </div>
            </div>
        </div>
    </div>
@stop
@section ('scriptFooter')
    <script type="text/javascript">
        $(function(){
           $('#tosAgree').on('change', function() {
              if ($(this).prop('checked')) {
                  $('#btnSubmit').removeAttr('disabled');
              } else {
                  $('#btnSubmit').prop('disabled', true);
              }
           });
        });
    </script>
@stop
