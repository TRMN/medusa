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
    foreach ($errors->all() as $message)
    {
        echo "<li>" . $message . "</li>\n";
    }
}
echo "</ul>\n";
?>

{{ Form::model( $user, [ 'route' => [ 'user.store' ], 'id' => 'newuser' ] ) }}
<div class="form-group">
    {{ Form::label('member_id', 'Member ID') }} {{ Form::text('member_id', 'RMN-') }}
</div>
<div class="form-group">
    {{ Form::label('first_name', 'First Name') }} {{ Form::text('first_name') }}
</div>
<div class="form-group">
    {{ Form::label('middle_name', 'Middle Name') }} {{ Form::text('middle_name') }}
</div>
<div class="form-group">
    {{ Form::label('last_name', 'Last Name') }} {{ Form::text('last_name') }}
</div>
<div class="form-group">
    {{ Form::label('suffix', 'Suffix') }} {{ Form::text('suffix') }}
</div>
<div class="form-group">
    {{ Form::label('address_1', 'Street Address') }} {{ Form::text('address_1') }}
</div>
<div class="form-group">
    {{ Form::label('address_2', 'Address Line 2') }} {{ Form::text('address_2') }}
</div>
<div class="form-group">
    {{ Form::label('city', 'City') }} {{ Form::text('city') }}
</div>
<div class="form-group">
    {{ Form::label('state_province', 'State/Province') }} {{ Form::text('state_province') }}
</div>
<div class="form-group">
    {{ Form::label('postal_code', 'Zip/Postal Code') }} {{ Form::text('postal_code') }}
</div>
<div class="form-group">
    {{ Form::label('country', 'Country') }} {{ Form::select('country') }}
</div>
<div class="form-group">
    {{ Form::label('phone_number', "Phone Number") }} {{ Form::text('phone_number') }}
</div>
<div class="form-group">
    {{ Form::label('email_address', 'Email') }} {{ Form::email('email_address') }}
</div>
<div class="form-group">
    {{ Form::label('branch', "Branch") }} {{ Form::select('branch') }}
</div>
<div class="form-group">
    {{ Form::label('permanent_rank', "Permanent Rank") }} {{ Form::select('permanent_rank', ['' => "Select a Rank"]) }}
</div>
<div class="form-group">
    {{ Form::label('perm_dor', "Date of Rank") }} {{ Form::text('perm_dor') }}
</div>
<div class="form-group">
    {{ Form::label('brevet_rank', "Brevet Rank") }} {{ Form::select('brevet_rank', ['' => 'Select a Rank']) }}
</div>
<div class="form-group">
    {{ Form::label('brevet_dor', "Date of Rank") }} {{ Form::text('brevet_dor') }}
</div>
<div class="form-group">
    {{ Form::label('rating', "Rating (if any)") }} {{ Form::select('rating', ['' => 'Select a Rating']) }}
</div>
<div class="form-group">
    {{ Form::label('primary_assignment', "Primary Assignment") }} {{ Form::select('primary_assignment', ['' => 'Select a Chapter']) }}
</div>
<div class="form-group">
    {{ Form::label('primary_billet', 'Billet') }} {{ Form::text('primary_billet') }}
</div>
<div class="form-group">
    {{ Form::label('primary_date_assigned', "Date Assigned") }} {{ Form::text('primary_date_assigned') }}
</div>

<a class="button" href="{{ route('user.index') }}">Cancel</a> {{ Form::submit( 'Save', [ 'class' => 'button'] ) }}
{{ Form::close() }}
@stop
