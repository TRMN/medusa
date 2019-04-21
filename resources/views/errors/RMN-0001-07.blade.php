@extends('layout')

@section('pageTitle')
    Bork Bork Bork
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 text-center">
            <div class="text-center"><img src="/images/swedish-chef.jpg" /></div>
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