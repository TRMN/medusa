@extends('layout')

@section('pageTitle')
{{{  $user->getGreeting() }}} {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}}
@stop

@section('content')
    @include('partials.servicerecord', array('user' => $user))
@stop
