@extends('layout')

@section('pageTitle')
    Open the Pod Bay Doors HAL
@stop

@section('content')
<div class="row">
    <div class=" col-sm-12 text-center">
        <h2>I'm sorry Dave, but I can't do that.</h2>

            <div class="text-center"><img src="/images/hal.svg" width="300px"></div>

        <h2>What seems to be the problem HAL?</h2>
    </div>
</div>

<div class="row">
    <div class="alert" data-alert>
        <p>@if(empty($e))
                {!! $exception->getMessage() !!}
            @else
                {!! $e->getMessage() !!}
            @endif
        </p>
        <p>Stack Trace:</p>
        <p class="small">
            @if(empty($e))
                {!! nl2br($exception->getTraceAsString()) !!}
            @else
                {!! nl2br($e->getTraceAsString()) !!}
            @endif
        </p>
        <p>{!!date('Y-m-d H:m:s')!!}</p>
    </div>
</div>

@stop