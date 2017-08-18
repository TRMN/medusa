@extends('layout')

@section('pageTitle')
Confirm Delete User
@stop

@section('content')
<h1>Confirm Delete User</h1>

<p>This will permanently delete member {!! $user->first_name !!} {!! $user->last_name !!} ({!! $user->member_id !!}) from the database. This is an unrecoverable action.  Are you sure?</p>
{!! Form::model( $user, [ 'route' => [ 'user.destroy', $user->id ], 'method' => 'delete' ] ) !!}
{!! Form::submit('Permanently Delete Member ' . $user->first_name . ' ' . $user->last_name . ' (' . $user->member_id . ')', ['class' => 'btn']) !!}
{!! Form::close() !!}
@stop