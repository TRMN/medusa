@extends('layout')

@section('pageTitle')
User {{{ $user->member_id }}}
@stop

@section('content')
<h2>User {{{ $user->member_id }}}</h2>
<ul>
    <li>{{{ $user->first_name }}} {{{ $user->last_name }}}</li>
    <li>{{{ $user->email }}}</li>
</ul>
@stop