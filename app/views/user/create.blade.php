@extends('layout')

@section('pageTitle')
Creating New User
@stop

@section('content')
<h1>Create New User</h1>
{{ Form::model( $user, [ 'route' => [ 'user.store' ] ] ) }}
<div class="form-group">
    {{ Form::label('first_name', 'First Name') }} {{ Form::text('first_name') }}
</div>
<div class="form-group">
    {{ Form::label('last_name', 'Last Name') }} {{ Form::text('last_name') }}
</div>
<div class="form-group">
    {{ Form::label('member_id', 'Member ID') }} {{ Form::text('member_id') }}
</div>
<div class="form-group">
    {{ Form::label('email', 'Email') }} {{ Form::email('email') }}
</div>
<div class="form-group">
    {{ Form::label('password', 'Password') }} {{ Form::password('password') }}
</div>
{{ Form::submit('Save') }}
{{ Form::close() }}
@stop