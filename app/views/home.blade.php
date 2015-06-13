@extends('layout')

@section('pageTitle')
Service Record
@stop

@section('content')
<h4 class="trmn my">Service Record</h4>

<div id="user-profile">
    <div class="Incised901Bold">
        {{ $user->getGreeting() }} {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}}
    </div>
    <div class="NordItalic">{{$user->getPrimaryAssignmentName()}} {{$user->getPrimaryAssignmentDesignation()}}</div>
    <div class="Incised901Light filePhoto">{{$user->member_id}}</div>
</div>
@stop
