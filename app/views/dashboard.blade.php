@extends('layout')

@section('pageTitle')
Dashboard
@stop

@section('content')
<h1>Dashboard</h1>

<div id="user-profile">
    <p>Hello, {{{ $authUser->first_name }}}.</p>
</div>
@stop