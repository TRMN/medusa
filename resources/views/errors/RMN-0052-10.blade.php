@extends('layout')

@section('pageTitle')
    I find your lack of faith... disturbing
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 text-center">
            <div class="text-center"><img src="https://s-media-cache-ak0.pinimg.com/236x/5b/53/02/5b53023a0e6eda295a1a74dd0ce9e92c--dark-helmet-role-models.jpg" width="300px"></div>
        </div>
    </div>

    <div class="row">
        <div class="alert" data-alert>
            <p>{!! $e->getMessage() !!}</p>
            <p>Stack Trace:</p>
            <p class="small">{!! nl2br($e->getTraceAsString()) !!}</p>
            <p>{!!date('Y-m-d H:m:s')!!}</p>
        </div>
    </div>

@stop