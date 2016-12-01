@extends( 'layout' )

@section('dochead')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@stop

@section( 'pageTitle' )
    Membership Application
@stop

@section( 'bodyclasses' )
    registerform
@stop

@section( 'content' )
    <h1>Membership Application</h1>

    {{ Form::model( $user, [ 'route' => [ 'user.apply' ], 'id' => 'register' ] ) }}

    <h2>The Basics</h2>
    <fieldset>
        <legend>You'll use your email address and password to log in to the site</legend>

        <div class="row">
            <div class="small-6 columns">
                {{ Form::label( 'email_address', 'Email' ) }} {{ Form::email( 'email_address' ) }}
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">
                {{ Form::label( 'password', 'Password' ) }} {{ Form::password( 'password' ) }}
            </div>
            <div class="small-6 columns">
                {{ Form::label( 'password_confirmation', 'Confirm Password' ) }} {{ Form::password( 'password_confirmation' ) }}
            </div>
        </div>
    </fieldset>

    <h2>Name</h2>
    <fieldset>
        <legend>We need to know what to call you</legend>

        <div class="row">
            <div class="small-4 columns">
                {{ Form::label( 'first_name', 'First Name' ) }} {{ Form::text( 'first_name' ) }}
            </div>
            <div class="small-3 columns">
                {{ Form::label( 'middle_name', 'Middle Name' ) }} {{ Form::text( 'middle_name' ) }}
            </div>
            <div class="small-4 columns">
                {{ Form::label( 'last_name', 'Last Name' ) }} {{ Form::text( 'last_name' ) }}
            </div>
            <div class="small-1 columns">
                {{ Form::label( 'suffix', 'Suffix' ) }} {{ Form::select('suffix', ['' => 'None', 'Jr' => 'Jr', 'Sr' => 'Sr', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', 'V' => 'V']) }}
            </div>
        </div>
    </fieldset>

    <h2>Address</h2>

    <fieldset>
        <legend>We only use this to help place you in the right chapter. We won't share this with anyone outside of the
            organization.
        </legend>

        <div class="row">
            <div class="small-6 columns">
                {{ Form::label( 'address1', 'Street Address' ) }} {{ Form::text( 'address1' ) }}
            </div>
            <div class="small-6 columns">
                {{ Form::label( 'address2', 'Address Line 2' ) }} {{ Form::text( 'address2' ) }}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns">
                {{ Form::label( 'city', 'City' ) }} {{ Form::text( 'city' ) }}
            </div>
            <div class="small-3 columns">
                {{ Form::label( 'state_province', 'State/Province' ) }} {{ Form::text( 'state_province' ) }}
            </div>
            <div class="small-3 columns">
                {{ Form::label( 'postal_code', 'Zip/Postal Code' ) }} {{ Form::text( 'postal_code' ) }}
            </div>
            <div class="small-3 columns">
                {{ Form::label( 'country', 'Country' ) }} {{ Form::select( 'country', $countries, 'USA' ) }}
            </div>
        </div>
    </fieldset>

    <h2>Age Verification</h2>
    <fieldset>
        <legend>We only use this to verify your eligibility for certain leadership positions</legend>
        <div class="small-6 columns end">
            {{ Form::label('dob', 'Date of Birth') }} {{Form::date('dob', $user->dob)}}
        </div>
    </fieldset>

    <h2>Branch</h2>

    <fieldset>
        <legend>Please choose which branch you would like to be part of</legend>
        <div class="row">
            <div class="small-6 columns end">
                {{ Form::label( 'branch', "Branch") }} {{ Form::select( 'branch', $branches, 'RMN' ) }}
            </div>
        </div>
    </fieldset>

    <h2>Chapter</h2>
    <fieldset>
        <legend>Please choose what chapter you would like to join. If you're not sure, choose one of the holding
            chapters. You may join any chapter, regardless of your branch
        </legend>
        <div class="row">
            <div class="small-2 columns">
                {{ Form::label( 'location', 'Location') }} {{ Form::select('location', $locations) }}
            </div>
            <div class="small-6 columns end">
                {{ Form::label( 'primary_assignment', "Chapter") }} {{ Form::select( 'primary_assignment', $chapters ) }}
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Terms of Service</legend>
        <div class="row">
            {{ Form::checkbox('tos',1, false, ['class' => 'switcher']) }} I have read and agree to the <a href="#"
                                                                                                          data-reveal-id="tos">Terms
                of Service</a>
        </div>
    </fieldset>
    <fieldset>
        <legend>Please prove that you're a sentient being</legend>
        <div class="row">
            <div class="small-4 columns end">
                <div class="g-recaptcha" data-sitekey="6LdcghoTAAAAAKKj3XEL4KMPcUJMUjigT-qwcRvQ"></div>
            </div>
        </div>
    </fieldset>
    {{ Form::submit( 'Sign me up!', [ 'class' => 'button' ] ) }}

    {{ Form::close() }}

    <div id="tos" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        @include('partials.tos')
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
@stop
@section ('scriptFooter')
<script type="application/javascript">
    $('.switcher').rcSwitcher({

    // reverse: true,
    inputs: false,
    // width: 70,
    // height: 24,
    // blobOffset: 2,
    onText: 'Yes',
    offText: 'No',
    theme: 'stoplight',
    // autoFontSize: true,

    });
</script>
@stop
