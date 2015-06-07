@extends('layout')

@section('pageTitle')
Editing User {{{ $user->getGreeting() }}} {{{ $user->first_name }}}{{{ isset( $user->middle_name ) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset( $user->suffix ) ? ' ' . $user->suffix : '' }}}
@stop

@section('bodyclasses')
userform
@stop

@section('content')
<h2>Editing {{{  $user->getGreeting() }}} {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}}</h2>
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
{{ Form::model( $user, [ 'route' => [ 'user.update', $user->id ], 'method' => 'put' ] ) }}
<div class="form-group">
    {{ Form::label('member_id', 'Member ID') }} {{ Form::text('member_id') }}
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
    {{ Form::label('country', 'Country') }} {{ Form::select('country', $countries) }}
</div>
<div class="form-group">
    {{ Form::label('phone_number', "Phone Number") }} {{ Form::text('phone_number') }}
</div>
<div class="form-group">
    {{ Form::label('email_address', 'Email') }} {{ Form::email('email_address') }}
</div>
<div class="form_group">
    {{ Form::label('password', 'Password') }} {{ Form::password('password') }}
</div>
<div class="form_group">
    {{ Form::label('password_confirmation', 'Confirm Password') }} {{ Form::password('password_confirmation') }}
</div>
<div class="form-group">
    {{ Form::label('branch', "Branch") }} {{ Form::select('branch', $branches) }}
</div>
<div class="form-group">
    {{ Form::label('display_rank', "Rank") }} {{ Form::select('display_rank', $grades) }}
</div>
<div class="form-group">
    {{ Form::label('dor', "Date of Rank") }} {{ Form::text('dor') }}
</div>
<div class="form-group">
    {{ Form::label('rating', "Rating (if any)") }} {{ Form::select('rating', $ratings) }}
</div>
<div class="form-group">
    {{ Form::label('primary_assignment', "Primary Assignment") }} {{ Form::select('primary_assignment', $chapters) }}
</div>
<div class="form-group">
    {{ Form::label('primary_billet', 'Billet') }} {{ Form::text('primary_billet') }}
</div>
<div class="form-group">
    {{ Form::label('primary_date_assigned', "Date Assigned") }} {{ Form::text('primary_date_assigned') }}
</div>
<a class="button" href="{{ route('user.index') }}">Cancel</a> {{ Form::submit('Save', [ 'class' => 'button' ] ) }}
{{ Form::close() }}
@stop
