@extends( 'layout' )

@section( 'pageTitle' )
Membership Application
@stop

@section( 'bodyclasses' )
registerform
@stop

@section( 'content' )
<h1>Membership Application</h1>

@if( $errors->any() )
    <ul class="errors">
        @foreach( $errors->all() as $error )
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

{{ Form::model( $user, [ 'route' => [ 'user.apply' ], 'id' => 'register' ] ) }}

<h2>The Basics</h2>

<p>You'll use your email address and password to log in to the site.</p>

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

<h2>Name</h2>

<p>We need to know what to call you!</p>

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
        {{ Form::label( 'suffix', 'Suffix' ) }} {{ Form::text( 'suffix' ) }}
    </div>
</div>

<h2>Address</h2>

<p>We only use this to help place you in the right chapter. We won't share this with anyone outside of the organization.</p>

<div class="row">
    <div class="small-6 columns">
        {{ Form::label( 'address_1', 'Street Address' ) }} {{ Form::text( 'address_1' ) }}
    </div>
    <div class="small-6 columns">
        {{ Form::label( 'address_2', 'Address Line 2' ) }} {{ Form::text( 'address_2' ) }}
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

<h2>Branch and Chapter</h2>

<p>If you know what branch and chapter you'd like to join, you may choose them here. One of the holding chapters is a good choice if you're not sure.</p>

<div class="row">
    <div class="small-6 columns">
        {{ Form::label( 'branch', "Branch") }} {{ Form::select( 'branch', $branches, 'RMN' ) }}
    </div>
    <div class="small-6 columns">
        {{ Form::label( 'primary_assignment', "Chapter") }} {{ Form::select( 'primary_assignment', $chapters ) }}
    </div>
</div>

{{ Form::submit( 'Sign me up!', [ 'class' => 'button' ] ) }}

{{ Form::close() }}

@stop