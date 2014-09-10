@extends('layout')

@section('content')
<h1>Dashboard</h1>

<div id="user-profile">
    <p>Hello, {{{ $user->first_name }}}.</p>
</div>
@stop