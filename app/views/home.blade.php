@extends('layout')

@section('pageTitle')
    Service Record
@stop

@section('content')
    @include('partials.servicerecord', array('user' => $user))
@stop
