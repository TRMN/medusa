@extends('layout')

@section('pageTitle')
    Terms of Service
@stop

@section('content')
    @include('partials.tos')
    {!! Form::open(['route' => 'tos', 'method' => 'post']) !!}
    {!! Form::hidden('id', Auth::user()->id) !!}
    {!! Form::hidden('tos',1) !!}
    <div>By clicking "I Agree", you agree that you have read and understand the Terms of Service</div>
    <div>
    <a class="btn"
       href="{!! route('signout') !!}">I do not agree</a> {!! Form::submit('I Agree', [ 'class' => 'btn' ] ) !!}
    </div>
    {!! Form::close() !!}
@stop
