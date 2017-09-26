@extends('layout')

@section('pageTitle')
    {!!  $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}
@stop

@section('content')
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#sr" aria-controls="sr" role="tab" data-toggle="tab">Service Record</a></li>
            <li role="presentation"><a href="#rr" aria-controls="rr" role="tab" data-toggle="tab">Ribbon Rack</a></li>
            <li role="presentation"><a href="#ar" aria-controls="ar" role="tab" data-toggle="tab">Academic Record</a></li>
            <li role="presentation"><a href="#pp" aria-controls="pp" role="tab" data-toggle="tab">Promotion Points</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active padding-top-10" id="sr">
                @include('partials.servicerecord', ['user' => $user])
            </div>

            <div role="tabpanel" class="tab-pane" id="rr">
                @include('partials.rack', ['user' => $user])
            </div>

            <div role="tabpanel" class="tab-pane" id="ar">
                @include('partials.coursework', ['user' => $user])
            </div>

            <div role="tabpanel" class="tab-pane" id="pp">
                @include('partials.points', ['user' => $user])
            </div>

        </div>
    </div>
@stop

@section('scriptFooter')
    <script>
        $('.nav-tabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>
@stop