@extends('layout')

@section('pageTitle')
    @if ($action == "add")
        Schedule an Event
    @else
        Edit an Event
    @endif
@stop

@section('dochead')
    <style>
        ::-webkit-input-placeholder {
            color: #66b2c9;
        }

        :-moz-placeholder {
            color: #66b2c9;
        }

        ::-moz-placeholdermoz-placeholder {
            color: #66b2c9;
        }

        ::-ms-input-placeholder {
            color: #66b2c9;
        }

        ::placeholder {
            color: #66b2c9;
        }

        .selectize-input,
        .selectize-input input {
            color: whitesmoke;
        }

        .selectize-dropdown,
        .selectize-input,
        .selectize-control.single .selectize-input,
        .selectize-control.single .selectize-input.input-active {
            background: #1c1c1d;
            color: whitesmoke;
        }

        .selectize-control.single .selectize-input,
        .selectize-dropdown.single {
            border-color: #29292a;
        }

        .selectize-control.single .selectize-input {
            padding: 2px 30px 2px 5px;
        }

        .selectize-control.single .selectize-input:after {
            border-top-color: whitesmoke;
        }

        .selectize-dropdown .active {
            color: #1c1c1d;
            background-color: #66b2c9;
        }

        .selectize-input .item {
            max-width: 95%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            margin-top: 0.60rem;
        }

        .selectize-input {
            min-height: 2.6875rem;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 Incised901Light">
            <h1>{!!$action == "add"? "Schedule": "Edit"!!} an Event</h1>
        </div>
    </div>
    <div class="row">
        <div class="colums col-sm-12 Incised901Light">
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
                    event on the mobile app to check members in for attendance. The event will not show up in the mobile
                    app until the date(s) of the event. If your event is not showing up, try signing out of the mobile
                    app and signing back in, or reloading your profile from the Profile menu.
                </li>
                <li>
                    The Event Coordinator will be able to edit the event until the first attendee has been checked in.
                </li>
                <li>The Event Coordinator will be able to download a .csv of the event attendance at any time the event
                    the
                    event has started by logging into MEDUSA and selecting their event.
                </li>
            </ol>
            </p>
        </div>
    </div>

    @if ($action == "add")
        {!! Form::model( $event, [ 'route' => [ 'events.store' ], 'method' => 'post', 'data-abide' => '', 'id' => 'event_form' ] ) !!}
    @else
        {!! Form::model( $event, [ 'route' => [ 'events.update', $event->_id ], 'method' => 'put', 'data-abide' => '', 'id' => 'event_form' ] ) !!}
    @endif
    <div class="row">
        <div class="col-sm-12">
            <fieldset id="location">
                <legend>Event Name and Location</legend>
                <div class="row">
                    <div class="col-sm-12 Incised901Light form-group">
                        <label for="event_name">Name of the event <span class="yellow">(required)</span></label>
                        {!! Form::text('event_name', empty($event->event_name)? null : $event->event_name, ['placeholder' => 'Name of the event', 'id' => 'event_name', 'required' => '', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class=" col-sm-12 Incised901Light form-group">
                        <label for="address1">Address Line 1 <span class="yellow">(required)</span></label>
                        {!! Form::text('address1', empty($event->address1)? null : $event->address1, ['placeholder' => 'Address line 1', 'id' => 'address1', 'required' => '', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 Incised901Light form-group">
                        {!!Form::label('address2', 'Address Line 2')!!}
                        {!!Form::text('address2', empty($event->address2)? null : $event->address2, ['placeholder' => 'Address line 2', 'id' => 'address2', 'class' => 'form-control'])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3  Incised901Light from-group">
                        <label for="city">City <span class="yellow">(required)</span></label>
                        {!! Form::text('city', empty($event->city)? null : $event->city, ['placeholder' => 'City', 'id' => 'city', 'required' => '', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3  Incised901Light form-group">
                        <label for="state_province">State/Province <span class="yellow">(required)</span></label>
                        {!! Form::text('state_province', empty($event->state_province)? null : $event->state_province, ['placeholder' => 'State / Province', 'id' => 'state_province', 'required' => '', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3  Incised901Light form-group">
                        <label for="postal_code">Zip/Postal Code <span class="yellow">(required)</span></label>
                        {!! Form::text('postal_code', empty($event->postal_code)? null : $event->postal_code, ['placeholder' => 'Zip / Postal Code', 'id' => 'postal_code', 'required' => '', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3  Incised901Light form-group">
                        <label for="country">Country <span class="yellow">(required)</span></label>
                        {!! Form::select('country', $countries, empty($event->country)? '' : $event->country, ['id' => 'country', 'required' => '']) !!}
                    </div>
                </div>
            </fieldset>
            <br/>
            <fieldset id="dates" class="padding-top-10">
                <legend>Dates and Event Registrars</legend>
                <div class="row">
                    <div class=" col-sm-6 Incised901Light form-group">
                        <label for="start_date">Start Date <span class="yellow">(required)</span></label>
                        {!! Form::date('start_date', empty($event->start_date)? null : $event->start_date, ['id' => 'start_date', 'required' => '', 'placeholder' => 'YYYY-MM-DD', 'class' => 'form-control']) !!}
                    </div>
                    <div class=" col-sm-6 Incised901Light form-group">
                        <label for="end_date">End Date <span
                                    class="alert">(Leave blank for a single day event)</span></label>
                        {!! Form::date('end_date', empty($event->end_date)? null : $event->end_date, ['id' => 'end_date', 'data-compare' => 'start_date', 'data-abide-validator' => 'greaterThanOrEqual', 'placeholder' => 'YYYY-MM-DD', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 Incised901Light form-group">
                        <label for="registrars">Event Registrars <span class="alert">(optional)</span></label>
                        {!!Form::select('registrars[]', [], null, ['id' => 'registrars', 'class' => 'white-border', 'placeholder' => 'Start typing a name to search'])!!}
                    </div>
                </div>
            </fieldset>
            <div class="text-center padding-top-10"><input type="submit" class="btn btn-success" value="Save"></div>
        </div>
    </div>

    {!!Form::close()!!}
@stop

@section('scriptFooter')
    <script type="text/javascript">
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
                    url: '{!!route('user.find.api')!!}/' + encodeURIComponent(query),
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
                    data: '{!!$registrar!!}',
                    value: '{!!App\User::find($registrar)->getFullName()!!} ({!!App\User::find($registrar)->getAssignmentName('primary')!!})'
                });
                self.addItem('{!!$registrar!!}');
                @endforeach
            }
            @endif
        });
    </script>
@stop