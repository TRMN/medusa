@extends('layout')

@section('pageTitle')
    Add a member
@stop

@section('dochead')
    <style>
        ::-webkit-input-placeholder {
            color: #66b2c9;
        }

        :-moz-placeholder {
            color: #66b2c9;
        }

        ::-moz-placeholdermoz-placeholder {
            color: #66b2c9;
        }

        ::-ms-input-placeholder {
            color: #66b2c9;
        }

        ::placeholder {
            color: #66b2c9;
        }

        .selectize-input,
        .selectize-input input {
            color: whitesmoke;
        }

        .selectize-dropdown,
        .selectize-input,
        .selectize-control.single .selectize-input,
        .selectize-control.single .selectize-input.input-active {
            background: #1c1c1d;
            color:  whitesmoke;
        }

        .selectize-control.single .selectize-input,
        .selectize-dropdown.single {
            border-color: #29292a;
        }

        .selectize-control.single .selectize-input {
            padding: 2px 30px 2px 5px;
        }

        .selectize-control.single .selectize-input:after {
            border-top-color: whitesmoke;
        }

        .selectize-dropdown .active {
            color: #1c1c1d;
            background-color: #66b2c9;
        }

        .selectize-input .item {
            max-width: 95%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            margin-top: 0.60rem;
        }

        .selectize-input {
            min-height: 2.6875rem;
        }
    </style>
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

    {!! Form::model( $user, [ 'route' => [ 'user.store' ], 'id' => 'user' ] ) !!}
    {!! Form::hidden('showUnjoinable', 'true', ['id' => 'showUnjoinable']) !!}
    <fieldset>
        <legend class="seventy-five Incised901Light">&nbsp;Personal Information&nbsp;</legend>
        <div class="row">
            <div class="small-6 columns ninety Incised901Light end">
                {!! Form::checkbox('honorary', 1) !!} Honorary Membership
            </div>
        </div>

        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {!! Form::label('email_address', 'E-Mail Address (This will be the Username)', ['class' => 'my']) !!}
                {!! Form::email('email_address') !!}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns ninety Incised901Light">
                {!! Form::label('first_name', 'First Name', ['class' => 'my']) !!} {!! Form::text('first_name') !!}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {!! Form::label('middle_name', 'Middle Name', ['class' => 'my']) !!} {!! Form::text('middle_name') !!}
            </div>
            <div class="small-3 columns ninety Incised901Light">
                {!! Form::label('last_name', 'Last Name', ['class' => 'my']) !!} {!! Form::text('last_name') !!}
            </div>
            <div class="small-1 columns ninety Incised901Light end">
                {!! Form::label('suffix', 'Suffix', ['class' => 'my']) !!} {!! Form::text('suffix') !!}
            </div>
        </div>

        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {!! Form::label('address1', 'Street Address', ['class' => 'my']) !!} {!! Form::text('address1') !!}
            </div>

        </div>
        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {!! Form::label('address2', 'Address Line 2', ['class' => 'my']) !!} {!! Form::text('address2') !!}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns ninety Incised901Light">
                {!! Form::label('city', 'City', ['class' => 'my']) !!} {!! Form::text('city') !!}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {!! Form::label('state_province', 'State/Province', ['class' => 'my']) !!} {!! Form::text('state_province') !!}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {!! Form::label('postal_code', 'Postal Code', ['class' => 'my']) !!} {!! Form::text('postal_code') !!}
            </div>
            <div class="end small-3 columns ninety Incised901Light">
                {!! Form::label('country', 'Country', ['class' => 'my']) !!} {!! Form::select('country', $countries, $user->country, ['class' => 'selectize']) !!}
            </div>
        </div>

        <div class="row">
            <div class="small-4 columns ninety Incised901Light">
                {!! Form::label('phone_number', "Phone Number", ['class' => 'my']) !!} {!! Form::text('phone_number') !!}
            </div>
            <div class="end small-4 columns ninety Incised901Light">
                {!! Form::label('dob', 'Date of Birth', ['class' => 'my']) !!} {!!Form::date('dob', $user->dob)!!}
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="small-4 columns ninety Incised901Light">
            {!! Form::label('password', 'Password', ['class' => 'my']) !!} {!! Form::password('password') !!}
        </div>
        <div class="end small-4 columns ninety Incised901Light">
            {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'my']) !!} {!! Form::password('password_confirmation') !!}
        </div>
    </div>
    <fieldset>
        <legend class="seventy-five Incised901Light">&nbsp;Service Information&nbsp;</legend>
        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {!! Form::label('branch', "Branch", ['class' => 'my']) !!} {!! Form::select('branch', $branches, null, ['class' => 'selectize']) !!}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {!! Form::label('display_rank', "Rank", ['class' => 'my']) !!} {!! Form::select('display_rank', $grades, null, ['class' => 'selectize']) !!}
            </div>
        </div>

        <div class="row">
            <div class="end small-4 columns ninety Incised901Light end">
                {!! Form::label('rating', "Rating (if any)", ['class' => 'my']) !!} {!! Form::select('rating', $ratings, null, ['class' => 'selectize']) !!}
            </div>
            <div class="end small-4 columns ninety Incised901Light end">
                {!! Form::label('dor', "Date of Rank", ['class' => 'my']) !!} {!! Form::date('dor') !!}
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend class="seventy-five Incised901Light">&nbsp;Assignment Information&nbsp;</legend>
        <div class="row">
            <div class="end small-6 columns ninety Incised901Light end">
                <div class="row">
                    <div class="small-12 columns ninety Incised901Light end">
                        {!! Form::label('primary_assignment', "Primary Assignment", ['class' => 'my']) !!} {!! Form::select('primary_assignment', $chapters) !!}
                    </div>
                </div>
            </div>
            <div class="end small-6 columns ninety Incised901Light end">
                <div class="row">
                    <div class="small-12 columns ninety Incised901Light end">
                        {!! Form::label('secondary_assignment', "Secondary Assignment", ['class' => 'my']) !!} {!! Form::select('secondary_assignment', $chapters) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="end small-6 columns ninety Incised901Light end">
                {!! Form::label('primary_billet', 'Billet', ['class' => 'my']) !!} {!! Form::select('primary_billet', $billets, null, ['class' => 'selectize']) !!}
            </div>
            <div class="end small-6 columns ninety Incised901Light end">
                {!! Form::label('secondary_billet', 'Billet', ['class' => 'my']) !!} {!! Form::select('secondary_billet', $billets, null, ['class' => 'selectize']) !!}
            </div>
        </div>

        <div class="row">
            <div class="end small-6 columns ninety Incised901Light end">
                {!! Form::label('primary_date_assigned', "Date Assigned", ['class' => 'my']) !!} {!! Form::date('primary_date_assigned') !!}
            </div>
            <div class="end small-6 columns ninety Incised901Light end">
                {!! Form::label('secondary_date_assigned', "Date Assigned", ['class' => 'my']) !!} {!! Form::date('secondary_date_assigned') !!}
            </div>
        </div>
    </fieldset>
    <a class="button" href="{!! route('user.index') !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'button'] ) !!}
    {!! Form::close() !!}
@stop
