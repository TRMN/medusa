@extends('layout')

@section('pageTitle')
    Editing User {{{ $user->getGreeting() }}} {{{ $user->first_name }}}{{{ isset( $user->middle_name ) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset( $user->suffix ) ? ' ' . $user->suffix : '' }}}
@stop

@section('bodyclasses')
    userform
@stop

@section('content')
    <h4 class="my NordItalic ninety">
        Editing {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}}</h4>
    <?php
    if (count($errors->all())) {
        echo "<p>Please correct the following errors:</p>\n<ul>\n";
        foreach ($errors->all() as $message) {
            echo "<li>" . $message . "</li>\n";
        }
    }
    echo "</ul>\n";
    ?>
    <div class="Incised901Light filePhoto">

        {{{$user->member_id}}}
        <div class="filePhotoBox">

            @if(file_exists(public_path() . $user->filePhoto) && isset($user->filePhoto) === true)
                <img src="{{{$user->filePhoto}}}" alt="Official File Photo">
            @endif
            <div class="ofpt">
                <form action='/api/photo' class='dropzone' id='trmnDropzone' method='post'
                      title="Drag and drop image files here or click.  Only .png, .gif and .jpg files will be accepted.  All images uploaded will be scaled to 150 pixels wide by 200 pixels tall.  After the image has been dropped, the form will be submitted and processed.">
                    {{ Form::hidden('member_id', $user->member_id) }}
                </form>
            </div>
        </div>
    </div>

    {{ Form::model( $user, [ 'route' => [ 'user.update', $user->id ], 'method' => 'put', 'id' => 'user' ] ) }}
    {{ Form::hidden('member_id', $user->member_idØ) }}
    {{ Form::hidden('reload_form', 'no', ['id' => 'reload_form']) }}
    <div class="row">
        <div class="small-8 columns ninety Incised901Light end">
            {{ Form::label('email_address', 'E-Mail Address (This is your Username)', ['class' => 'my']) }}
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
            {{ Form::label('address1', 'Street Address', ['class' => 'my']) }} {{ Form::text('address1') }}
        </div>

    </div>
    <div class="row">
        <div class="small-8 columns ninety Incised901Light end">
            {{ Form::label('address2', 'Address Line 2', ['class' => 'my']) }} {{ Form::text('address2') }}
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

    <div class="row">
        <div class="small-4 columns ninety Incised901Light">
            {{ Form::label('password', 'Password', ['class' => 'my']) }} {{ Form::password('password') }}
        </div>
        <div class="end small-4 columns ninety Incised901Light">
            {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'my']) }} {{ Form::password('password_confirmation') }}
        </div>
    </div>
    <fieldset class="yellow-border" id="transfers" style="width: 575px">
        <div class="row">
            <div class="end small-11 columns Incised901Light ninety">All Branch and Chapter reassignments must be
                approved by BuPers
            </div>
        </div>
        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('branch', "Branch", ['class' => 'my']) }} {{ Form::select('branch', $branches, $user->branch) }}
            </div>
        </div>
        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('primary_assignment', "Primary Assignment", ['class' => 'my']) }} {{ Form::select('primary_assignment', $chapters) }}
            </div>
        </div>
        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('primary_billet', 'Billet', ['class' => 'my']) }} {{ Form::select('primary_billet', $billets) }}
            </div>
        </div>
        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('primary_date_assigned', "Date Assigned", ['class' => 'my']) }} {{ Form::date('primary_date_assigned', $user->primary_date_assigned) }}
            </div>
        </div>

        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('secondary_assignment', "Secondary Assignment", ['class' => 'my']) }} {{ Form::select('secondary_assignment', $chapters) }}
            </div>
        </div>
        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('secondary_billet', 'Billet', ['class' => 'my']) }} {{ Form::select('secondary_billet', $billets) }}
            </div>
        </div>
        <div class="row">
            <div class="end small-11 columns ninety Incised901Light">
                {{ Form::label('secondary_date_assigned', "Date Assigned", ['class' => 'my']) }} {{ Form::date('secondary_date_assigned', $user->secondary_date_assigned) }}
            </div>
        </div>

    </fieldset>

    <div class="row">
        <div class="end small-4 columns ninety Incised901Light">
            {{ Form::label('display_rank', "Rank", ['class' => 'my']) }} {{ Form::select('display_rank', $grades) }}
        </div>
    </div>
    <div class="row">
        <div class="end small-4 columns ninety Incised901Light">
            {{ Form::label('dor', "Date of Rank", ['class' => 'my']) }} {{ Form::date('dor') }}
        </div>
    </div>
    <div class="row">
        <div class="end small-4 columns ninety Incised901Light">
            {{ Form::label('rating', "Rating (if any)", ['class' => 'my']) }} {{ Form::select('rating', $ratings) }}
        </div>
    </div>

    <a class="button"
       href="{{ route('user.index') }}">Cancel</a> {{ Form::submit('Save', [ 'class' => 'button' ] ) }}

    {{ Form::close() }}

    <div id="photoModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <div class="row">
            <div class="small-2 columns trmn-width" id="pm1">
                <img src="{{{$serverUrl}}}/images/trmn-seal.png" alt="TRMN Seal">
            </div>
            <div class="small-10 columns Incised901Light" id="pm2">
                <p></p>
            </div>
        </div>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

@stop

