@extends('layout')

@section('pageTitle')
    Bork Bork Bork
@stop

@section('content')
    <div class="row">
        <div class="columns small-12 text-center">
            <div class="text-center"><img src="/images/swedish-chef.jpg" /></div>
        </div>
    </div>

    <div class="row">
        <div class="alert-box" data-alert>
            <p>{!! $e->getMessage() !!}</p>
            <p>Stack Trace:</p>
            <p class="small">{!! nl2br($e->getTraceAsString()) !!}</p>
            <p>{!!date('Y-m-d H:m:s')!!}</p>
        </div>
    </div>

@stop