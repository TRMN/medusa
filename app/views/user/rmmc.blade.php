@extends('layout')

@section('pageTitle')
    {{ $title }}
@stop

@section('content')
    <div><h3 class="trmn">{{ $title }}</h3></div>
    <div>
        @include('user.partials.rmmc')
    </div>
@stop