@extends('layout')

@section('pageTitle')
Editing User {{{ $user->member_id }}}
@stop

@section('content')
<h2>Editing User {{{ $user->member_id }}}</h2>
{{ Form::model( $user, [ 'route' => [ 'user.update', $user->id ] ] ) }}
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
{{ Form::submit('Save') }}
{{ Form::close() }}
@stop