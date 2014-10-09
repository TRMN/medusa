@extends('layout')

@section('pageTitle')
{{{ $greeting }}} {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}
@stop

@section('content')
<h2>{{{ $greeting }}} {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}</h2>
<ul>
    <li>{{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}</li>
    <li>{{{ $user->email_address }}}</li>
</ul>
@stop
