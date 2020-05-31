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
    if (!empty($errors->all())) {
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
        <legend class="Incised901Light">&nbsp;Personal Information&nbsp;</legend>
        <div class="row">
            <div class="col-sm-6 Incised901Light">
                {!! Form::checkbox('honorary', 1) !!} Honorary Membership
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-8 Incised901Light form-group">
                {!! Form::label('email_address', 'E-Mail Address (This will be the Username)', ['class' => 'my']) !!}
                {!! Form::email('email_address', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 Incised901Light form-group">
                {!! Form::label('first_name', 'First Name', ['class' => 'my']) !!} {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-2 Incised901Light form-group">
                {!! Form::label('middle_name', 'Middle Name', ['class' => 'my']) !!} {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-3 Incised901Light form-group">
                {!! Form::label('last_name', 'Last Name', ['class' => 'my']) !!} {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-1 Incised901Light form-group">
                {!! Form::label('suffix', 'Suffix', ['class' => 'my']) !!} {!! Form::text('suffix', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 Incised901Light form-group">
                {!! Form::label('address1', 'Street Address', ['class' => 'my']) !!} {!! Form::text('address1', null, ['class' => 'form-control']) !!}
            </div>

        </div>
        <div class="row">
            <div class="col-sm-8 Incised901Light form-group">
                {!! Form::label('address2', 'Address Line 2', ['class' => 'my']) !!} {!! Form::text('address2', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 Incised901Light form-group">
                {!! Form::label('city', 'City', ['class' => 'my']) !!} {!! Form::text('city', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-2 Incised901Light form-group">
                {!! Form::label('state_province', 'State/Province', ['class' => 'my']) !!} {!! Form::text('state_province', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-2 Incised901Light form-group">
                {!! Form::label('postal_code', 'Postal Code', ['class' => 'my']) !!} {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-3 Incised901Light form-group">
                {!! Form::label('country', 'Country', ['class' => 'my']) !!} {!! Form::select('country', $countries, $user->country, ['class' => 'selectize']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 Incised901Light form-group">
                {!! Form::label('phone_number', "Phone Number", ['class' => 'my']) !!} {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
            </div>
            <div class=" col-sm-4 Incised901Light form-group">
                {!! Form::label('dob', 'Date of Birth', ['class' => 'my']) !!} {!!Form::date('dob', null, ['class' => 'form-control'])!!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 Incised901Light form-group">
                {!! Form::label('password', 'Password', ['class' => 'my']) !!} {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class=" col-sm-4 Incised901Light form-group">
                {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'my']) !!} {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend class="Incised901Light">&nbsp;Service Information&nbsp;</legend>
        <div class="row">
            <div class=" col-sm-4 Incised901Light form-group">
                {!! Form::label('branch', "Branch", ['class' => 'my']) !!} {!! Form::select('branch', $branches, null, ['class' => 'selectize']) !!}
            </div>
            <div class=" col-sm-4 Incised901Light form-group">
                {!! Form::label('display_rank', "Rank", ['class' => 'my']) !!} {!! Form::select('display_rank', $grades, null, ['class' => 'selectize']) !!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-4 Incised901Light form-group">
                {!! Form::label('rating', "Rating (if any)", ['class' => 'my']) !!} {!! Form::select('rating', $ratings, null, ['class' => 'selectize']) !!}
            </div>
            <div class=" col-sm-4 Incised901Light form-group">
                {!! Form::label('dor', "Date of Rank", ['class' => 'my']) !!} {!! Form::date('dor', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend class="Incised901Light">&nbsp;Assignment Information&nbsp;</legend>
        <div class="row">
            <div class=" col-sm-6 Incised901Light form-group">
                <div class="row">
                    <div class="col-sm-12 Incised901Light form-group">
                        {!! Form::label('primary_assignment', "Primary Assignment", ['class' => 'my']) !!} {!! Form::select('primary_assignment', $chapters, null, ['class' => 'selectize']) !!}
                    </div>
                </div>
            </div>
            <div class=" col-sm-6 Incised901Light form-group">
                <div class="row">
                    <div class="col-sm-12 Incised901Light form-group">
                        {!! Form::label('secondary_assignment', "Secondary Assignment", ['class' => 'my']) !!} {!! Form::select('secondary_assignment', $chapters, null, ['class' => 'selectize']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-6 Incised901Light form-group">
                {!! Form::label('primary_billet', 'Billet', ['class' => 'my']) !!} {!! Form::select('primary_billet', $billets, null, ['class' => 'selectize']) !!}
            </div>
            <div class=" col-sm-6 Incised901Light form-group">
                {!! Form::label('secondary_billet', 'Billet', ['class' => 'my']) !!} {!! Form::select('secondary_billet', $billets, null, ['class' => 'selectize']) !!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-6 Incised901Light form-group">
                {!! Form::label('primary_date_assigned', "Date Assigned", ['class' => 'my']) !!} {!! Form::date('primary_date_assigned', null, ['class' => 'form-control']) !!}
            </div>
            <div class=" col-sm-6 Incised901Light form-group">
                {!! Form::label('secondary_date_assigned', "Date Assigned", ['class' => 'my']) !!} {!! Form::date('secondary_date_assigned', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </fieldset>

    <div class="row">
        <div class="col-sm-8 Incised901Light text-center">
            <a class="btn btn-danger" href="{!! URL::previous() !!}"><span class="fa fa-times"></span>
                <strong>Cancel</strong> </a>
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong>
            </button>
        </div>
    </div>

    {!! Form::close() !!}
@stop
