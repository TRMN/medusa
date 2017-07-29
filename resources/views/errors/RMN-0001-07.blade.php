@extends('layout')

@section('pageTitle')
    Bork Bork Bork
@stop

@section('content')
    <div class="row">
        <div class="columns small-12 text-center">
            <div class="text-center"><img src="https://s-media-cache-ak0.pinimg.com/736x/c8/2d/08/c82d08d89496fe4d8d30cdfa2de890d3--swedish-chef-chefs.jpg" width="300px"></div>
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