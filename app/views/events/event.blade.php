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
                <li>
                    The Event Coordinator will be able to edit the event until the first attendee has been checked in.
                </li>
                <li>The Event Coordinator will be able to download a .csv of the event attendance at any time the event the
                    event has started by logging into MEDUSA and selecting their event.
                </li>
            </ol>
            </p>
        </div>
    </div>
    @if ($action == "add")
        {{ Form::model( $event, [ 'route' => [ 'events.store' ], 'method' => 'post', 'data-abide' => '', 'id' => 'event_form' ] ) }}
    @else
        {{ Form::model( $event, [ 'route' => [ 'events.update', $event->_id ], 'method' => 'put', 'data-abide' => '', 'id' => 'event_form' ] ) }}
    @endif
    <div class="row">
        <div class="columns small-8 end">
            <fieldset id="location">
                <legend>Event Name and Location</legend>
                <div class="row">
                    <div class="columns small-12 Incised901Light">
                        <label for="event_name">Name of the event <span class="yellow">(required)</span></label>
                        {{ Form::text('event_name', empty($event->event_name)? null : $event->event_name, ['placeholder' => 'Name of the event', 'id' => 'event_name', 'required' => '']) }}
                        <small class="error">The name of the event is required</small>
                    </div>
                </div>
                <div class="row">
                    <div class="column small-12 Incised901Light">
                        <label for="address1">Address Line 1 <span class="yellow">(required)</span></label>
                        {{ Form::text('address1', empty($event->address1)? null : $event->address1, ['placeholder' => 'Address line 1', 'id' => 'address1', 'required' => '']) }}
                        <small class="error">You must provide a location</small>
                    </div>
                </div>
                <div class="row">
                    <div class="columns small=12 Incised901Light">
                        {{Form::label('address2', 'Address Line 2')}}
                        {{Form::text('address2', empty($event->address2)? null : $event->address2, ['placeholder' => 'Address line 2', 'id' => 'address2'])}}
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns Incised901Light">
                        <label for="city">City <span class="yellow">(required)</span></label>
                        {{ Form::text('city', empty($event->city)? null : $event->city, ['placeholder' => 'City', 'id' => 'city', 'required' => '']) }}
                        <small class="error">City is required</small>
                    </div>
                    <div class="small-3 columns Incised901Light">
                        <label for="state_province">State/Province <span class="yellow">(required)</span></label>
                        {{ Form::text('state_province', empty($event->state_province)? null : $event->state_province, ['placeholder' => 'State / Province', 'id' => 'state_province', 'required' => '']) }}
                        <small class="error">State/Province is required</small>
                    </div>
                    <div class="small-3 columns Incised901Light">
                        <label for="postal_code">Zip/Postal Code <span class="yellow">(required)</span></label>
                        {{ Form::text('postal_code', empty($event->postal_code)? null : $event->postal_code, ['placeholder' => 'Zip / Postal Code', 'id' => 'postal_code', 'required' => '']) }}
                        <small class="error">Zip/Postal Code is required</small>
                    </div>
                    <div class="small-3 columns Incised901Light">
                        <label for="country">Country <span class="yellow">(required)</span></label>
                        {{ Form::select('country', $countries, empty($event->country)? '' : $event->country, ['id' => 'country', 'required' => '']) }}
                        <small class="error">Country is required</small>
                    </div>
                </div>
            </fieldset>
            <fieldset id="dates">
                <legend>Dates and Event Registrars</legend>
                <div class="row">
                    <div class="columns small-6 Incised901Light">
                        <label for="start_date">Start Date <span class="yellow">(required)</span></label>
                        {{ Form::date('start_date', empty($event->start_date)? null : $event->start_date, ['id' => 'start_date', 'required' => '']) }}
                        <small class="error">Start date is required</small>
                    </div>
                    <div class="columns small-6 Incised901Light">
                        <label for="end_date">End Date <span
                                    class="alert">(Leave blank for a single day event)</span></label>
                        {{ Form::date('end_date', empty($event->end_date)? null : $event->end_date, ['id' => 'end_date', 'data-compare' => 'start_date', 'data-abide-validator' => 'greaterThanOrEqual']) }}
                        <small class="error">End date can not be before start date</small>
                    </div>
                </div>
                <div class="row">
                    <div class="columns small=12 Incised901Light">
                        <label for="registrars">Event Registrars <span class="alert">(optional)</span></label>
                        {{Form::select('registrars[]', [], null, ['id' => 'registrars'])}}
                    </div>
                </div>
            </fieldset>
            <div class="text-center"><input type="submit" class="button" value="Save"></div>
        </div>
    </div>

    {{Form::close()}}
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(document).foundation({
            abide: {
                timeout: 1,
                validators: {
                    greaterThanOrEqual: function (el, required, parent) {

                        var start = document.getElementById(el.getAttribute(this.add_namespace('data-compare'))).value,
                                end = el.value;
                        if (end == '') {
                            return true;
                        }
                        return end >= start;
                    }
                }
            }
        });

        $('#country').selectize({
            openOnFoucs: false,
            closeAfterSelect: true,
            selectOnTab: true
        });

        $('#registrars').selectize({
            valueField: 'data',
            labelField: 'value',
            searchField: 'value',
            maxItems: null,
            create: false,
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '{{route('user.find.api')}}/' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res.suggestions);
                    }
                });
            }@if($action !='add'),
            onInitialize: function () {
                var self = this;
                @foreach($event->registrars as $registrar)
                    self.addOption({
                    data: '{{$registrar}}',
                    value: '{{User::find($registrar)->getFullName()}} ({{User::find($registrar)->getAssignmentName('primary')}})'
                });
                self.addItem('{{$registrar}}');
                @endforeach
            }
            @endif
        });
    </script>
@stop