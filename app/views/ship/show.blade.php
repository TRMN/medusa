@extends('layout')

@section('pageTitle')
{{{ $ship->title }}}
@stop

@section('content')
<ul>
    <li>{{{ $ship->title }}}</li>
</ul>
@stop