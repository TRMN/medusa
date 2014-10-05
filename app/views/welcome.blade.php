@extends('layout')

@section('pageTitle')
Welcome
@stop

@section('content')
<h1>The Royal Manticoran Navy Database</h1>

@if( !Auth::check() )
    <h2>Please Log In</h2>
    <input id="email" name="email" placeholder="email" type="email">
    <input id="password" name="password" type="password" placeholder="password">
    <a href="#" id="signin-btn" class="button expand">Sign in</a>
@endif

@stop