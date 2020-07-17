@extends('layout')

@section('pageTitle')
    Your Scheduled Events
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 Incised901Light">
            <h1>Your Scheduled Events</h1>
        </div>
    </div>

    @if(!empty($events))
        <div class="row">
            <div class=" col-sm-3 Incised901Light underline">Dates</div>
            <div class=" col-sm-9 Incised901Light underline">Click to Edit/Download CSV</div>
        </div>
        <div class="row">
            <div class=" col-sm-12">
                <br/>
            </div>
        </div>
        @foreach($events as $event)
            <div class="row">
                <div class=" col-sm-3 Incised901Light">
                    {!!date('M j, Y', strtotime($event->start_date))!!}@if(!empty($event->end_date))
                        - {!!date('M j, Y', strtotime($event->end_date))!!}@endif
                </div>
                <div class=" col-sm-9 Incised901Light">
                    <a href="
                        @if (isset($event->checkins))
                    {!!route('event.export', [$event->_id])!!}
                    @else
                    {!!route('events.edit', [$event->_id])!!}
                    @endif
                            ">{!!$event->event_name!!}</a>
                </div>
            </div>
        @endforeach
    @else
        <div class="row">
            <div class=" col-sm-12 Incised901Light"><h3>You have not scheduled any events</h3></div>
        </div>
    @endif

@stop
