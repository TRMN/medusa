@extends('layout')

@section('pageTitle')
    @if ($action == "add")
        Schedule an Event
    @else
        Edit an Event
    @endif
@stop

@section('content')
    <div class="row">
        <div class="columns small-12 Incised901Light">
            <h1>{{$action == "add"? "Schedule": "Edit"}} an Event</h1>
        </div>
    </div>
    <div class="row">
        <div class="colums small-12 Incised901Light">
            <p>This is MEDUSA Event Scheduler. All events are created here in the web application. Events can be
                scheduled to track who volunteered and worked at a convention or recruiting table, attended a gaming
                session or some other chapter activity. Using the MEDUSA Mobile app, you and individuals you designate
                will be able to scan a members ID card to record them as having attended the event. The scan will work
                with the physical ID card or an ID card displayed on a members smart phone.
            <ol>
                <li>As the creator of this event, you will be listed as the Event Coordinator.</li>
                <li>
                    Scheduled events must include the physical address of the event, date, time and Event Registrars. A
                    registrar is one or more optional individuals who can check people into the event in addition to the
                    Event Coordinator.
                </li>
                <li>Event Registrars and the Event Coordinator will use the MEDUSA Mobile app to scan ID cards to check
                    people into events. A Registrar or Event Coordinator will be the only people that can access the
                    event on the mobile app to check members in for attendance.
                </li>
                <li>The Event Coordinator will be able to download a .csv of the event attendance after the event has
                    concluded by logging into MEDUSA and selecting their event.
                </li>
            </ol>
            </p>
        </div>
    </div>
    @if ($action = "add")
        {{ Form::model( $event, [ 'route' => [ 'events.store' ], 'method' => 'post' ] ) }}
    @else
        {{ Form::model( $event, [ 'route' => [ 'events.update', $event->_id ], 'method' => 'put' ] ) }}
    @endif

    {{Form::close()}}
@stop
