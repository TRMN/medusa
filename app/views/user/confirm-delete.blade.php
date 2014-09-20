@extends('layout')

@section('pageTitle')
Confirm Delete User
@stop

@section('content')
<h2>Confirm Delete User</h2>

<p>This will permanently delete user {{{ $user->member_id }}}. Are you sure?</p>
{{ Form::model( $user, [ 'route' => [ 'user.destroy', $user->id ], 'method' => 'delete' ] ) }}
{{ Form::submit('Annihilate') }}
{{ Form::close() }}
@stop