@extends('layout')

@section('pageTitle')
    Add a member
@stop

@section('bodyclasses')
    userform
@stop

@section('content')
    <h1>Add a Member</h1>

    <?php
    if (count($errors->all())) {
        echo "<p>Please correct the following errors:</p>\n<ul>\n";
        foreach ($errors->all() as $message) {
            echo "<li>" . $message . "</li>\n";
        }
    }
    echo "</ul>\n";
    ?>

    {{ Form::model( $user, [ 'route' => [ 'user.store' ], 'id' => 'user' ] ) }}
    <fieldset>
        <legend class="seventy-five Incised901Light">&nbsp;Personal Information&nbsp;</legend>
        <div class="row">
            <div class="small-6 columns ninety Incised901Light end">
                {{ Form::checkbox('honorary', 1) }} Honorary Membership
            </div>
        </div>

        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {{ Form::label('email_address', 'E-Mail Address (This will be the Username)', ['class' => 'my']) }}
                {{ Form::email('email_address') }}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns ninety Incised901Light">
                {{ Form::label('first_name', 'First Name', ['class' => 'my']) }} {{ Form::text('first_name') }}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {{ Form::label('middle_name', 'Middle Name', ['class' => 'my']) }} {{ Form::text('middle_name') }}
            </div>
            <div class="small-3 columns ninety Incised901Light">
                {{ Form::label('last_name', 'Last Name', ['class' => 'my']) }} {{ Form::text('last_name') }}
            </div>
            <div class="small-1 columns ninety Incised901Light end">
                {{ Form::label('suffix', 'Suffix', ['class' => 'my']) }} {{ Form::text('suffix') }}
            </div>
        </div>

        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {{ Form::label('address_1', 'Street Address', ['class' => 'my']) }} {{ Form::text('address_1') }}
            </div>

        </div>
        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {{ Form::label('address_2', 'Address Line 2', ['class' => 'my']) }} {{ Form::text('address_2') }}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns ninety Incised901Light">
                {{ Form::label('city', 'City', ['class' => 'my']) }} {{ Form::text('city') }}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {{ Form::label('state_province', 'State/Province', ['class' => 'my']) }} {{ Form::text('state_province') }}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {{ Form::label('postal_code', 'Postal Code', ['class' => 'my']) }} {{ Form::text('postal_code') }}
            </div>
            <div class="end small-3 columns ninety Incised901Light">
                {{ Form::label('country', 'Country', ['class' => 'my']) }} {{ Form::select('country', $countries, $user->country) }}
            </div>
        </div>

        <div class="row">
            <div class="small-4 columns ninety Incised901Light">
                {{ Form::label('phone_number', "Phone Number", ['class' => 'my']) }} {{ Form::text('phone_number') }}
            </div>
            <div class="end small-4 columns ninety Incised901Light">
                {{ Form::label('dob', 'Date of Birth', ['class' => 'my']) }} {{Form::date('dob', $user->dob)}}
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="small-4 columns ninety Incised901Light">
            {{ Form::label('password', 'Password', ['class' => 'my']) }} {{ Form::password('password') }}
        </div>
        <div class="end small-4 columns ninety Incised901Light">
            {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'my']) }} {{ Form::password('password_confirmation') }}
        </div>
    </div>
    <fieldset>
        <legend class="seventy-five Incised901Light">&nbsp;Service Information&nbsp;</legend>
        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('branch', "Branch", ['class' => 'my']) }} {{ Form::select('branch', $branches) }}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('display_rank', "Rank", ['class' => 'my']) }} {{ Form::select('display_rank', $grades) }}
            </div>
        </div>

        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('rating', "Rating (if any)", ['class' => 'my']) }} {{ Form::select('rating', $ratings) }}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('dor', "Date of Rank", ['class' => 'my']) }} {{ Form::date('dor') }}
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend class="seventy-five Incised901Light">&nbsp;Assignment Information&nbsp;</legend>
        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('primary_assignment', "Primary Assignment", ['class' => 'my']) }} {{ Form::select('primary_assignment', $chapters) }}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('secondary_assignment', "Secondary Assignment", ['class' => 'my']) }} {{ Form::select('secondary_assignment', $chapters) }}
            </div>
        </div>

        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('primary_billet', 'Billet', ['class' => 'my']) }} {{ Form::text('primary_billet') }}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('secondary_billet', 'Billet', ['class' => 'my']) }} {{ Form::text('secondary_billet') }}
            </div>
        </div>

        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('primary_date_assigned', "Date Assigned", ['class' => 'my']) }} {{ Form::date('primary_date_assigned') }}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {{ Form::label('secondary_date_assigned', "Date Assigned", ['class' => 'my']) }} {{ Form::date('secondary_date_assigned') }}
            </div>
        </div>
    </fieldset>
    <a class="button" href="{{ route('user.index') }}">Cancel</a> {{ Form::submit( 'Save', [ 'class' => 'button'] ) }}
    {{ Form::close() }}
@stop
