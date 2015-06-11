@extends('layout')

@section('pageTitle')
Confirm Delete User
@stop

@section('content')
<h1>Confirm Delete User</h1>

<p>This will permanently delete user {{{ $user->first_name }}} {{{ $user->last_name }}} ({{{ $user->member_id }}}). Are you sure?</p>
{{ Form::model( $user, [ 'route' => [ 'user.destroy', $user->id ], 'method' => 'delete' ] ) }}
{{ Form::submit('Annihilate') }}
{{ Form::close() }}
@stop