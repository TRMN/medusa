@extends('layout')

@section('pageTitle')
    Event Information
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 text-center Incised901Light">
            <h1>{!!$event->event_name!!}</h1>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-1 Incised901Light">Location:</div>
        <div class=" col-sm-11 Incised901Light">
            {!!$event->address1!!}<br/>
            @if (!empty($event->address2))
                {!!$event->address2!!}<br/>
            @endif
            {!!$event->city!!}, {!!$event->state_province!!}&nbsp;&nbsp;{!!$event->postal_code!!}<br>
            {!!$countries[$event->country]!!}
        </div>
    </div>
    <br />
    <div class="row">
        <div class=" col-sm-1 Incised901Light">Dates:</div>
        <div class=" col-sm-11 Incised901Light">
            {!!date('M jS, Y', strtotime($event->start_date))!!}@if(!empty($event->end_date))
                to {!!date('M jS, Y', strtotime($event->end_date))!!}@endif
        </div>
    </div>

    @if(!empty($event->registrars))
        <br />
        <div class="row">
            <div class=" col-sm-1 Incised901Light">Registrars:</div>
            <div class=" col-sm-11 Incised901Light">
                @foreach($event->registrars as $registrar)
                    {!!App\Models\User::find($registrar)->getFullName()!!}<br/>
                @endforeach
            </div>
        </div>
    @endif
@stop
