@extends('layout')

@section('pageTitle')
Dashboard
@stop

@section('content')
<h1>Dashboard</h1>

<div id="user-profile">
    <p>Welcome, <span class="user-rank">{{ $authUser->permanent_rank }}</span><span class="user-last-name">{{ $authUser->last_name }}</span>!</p>
</div>
@stop