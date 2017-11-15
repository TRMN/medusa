@extends('layout')

@section('pageTitle')
    {!!  $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}
@stop

@section('content')
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#sr" aria-controls="sr" role="tab" data-toggle="tab">Service
                    Record</a></li>
            <li role="presentation"><a href="#rr" aria-controls="rr" role="tab" data-toggle="tab">Ribbon Rack</a></li>
            <li role="presentation"><a href="#ar" aria-controls="ar" role="tab" data-toggle="tab">Academic Record</a>
            </li>
            @if(($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || $permsObj->hasPermissions(['EDIT_MEMBER']) || $permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($user) === true)
                <li role="presentation"><a href="#pp" aria-controls="pp" role="tab" data-toggle="tab">Promotion
                        Points</a></li>
            @endif
            @if(count($user->history))
                <li role="presentation"><a href="#sh" aria-controls="sh" role="tab" data-toggle="tab">Service
                        History</a></li>
            @endif
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
            @if(($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || $permsObj->hasPermissions(['EDIT_MEMBER']) || $permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($user) === true)
                <div role="tabpanel" class="tab-pane" id="pp">
                    @include('partials.points', ['user' => $user])
                </div>
            @endif
            @if(count($user->history))
                <div role="tabpanel" class="tab-pane" id="sh">
                    <h3>Service History</h3><br />
                    @foreach($user->history as $item)
                        <div class="row">
                            <div class="col-sm-12">
                                {{$item['description']}} on {{date('d M Y', strtotime($item['date']))}}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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