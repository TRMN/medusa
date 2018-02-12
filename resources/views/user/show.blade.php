@extends('layout')

@section('pageTitle')
    {!!  $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}
@stop

@section('content')
    <div>
        @if($user->registration_status != "Pending")
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#sr" aria-controls="sr" role="tab" data-toggle="tab">Service
                        Record</a></li>

                <li role="presentation"><a href="#rr" aria-controls="rr" role="tab" data-toggle="tab">Ribbon Rack</a>
                </li>
                <li role="presentation"><a href="#ar" aria-controls="ar" role="tab" data-toggle="tab">Academic
                        Record</a>
                </li>
                @if(($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || $permsObj->hasPermissions(['EDIT_MEMBER']) || $permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($user) === true)
                    <li role="presentation"><a href="#pp" aria-controls="pp" role="tab" data-toggle="tab">Promotion
                            Points</a></li>
                @endif
                @if(count($user->history))
                    <li role="presentation"><a href="#history" aria-controls="sh" role="tab" data-toggle="tab">Service
                            History</a></li>
                @endif
            </ul>
        @endif
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active padding-top-10" id="sr">
                @include('partials.servicerecord', ['user' => $user])
            </div>
            @if($user->registration_status != "Pending")
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
                @if(!empty($user->history))
                    <div role="tabpanel" class="tab-pane" id="history">
                        <div class="history-content">
                            <h2 class="text-center">Service History</h2><br/>
                            @foreach($user->history as $item)
                                @if ($loop->first && substr($item['event'], 0, 7) != 'Applied')
                                    <div class="row zebra-odd padding-top-10 padding-bottom-10">
                                        <div class="col-sm-12">
                                            Applied on {{date('d M Y', strtotime($user->application_date))}}
                                        </div>
                                    </div>
                                    <div class="row zebra-odd padding-top-10 padding-bottom-10">
                                        <div class="col-sm-12">
                                            Application approved by BuPers
                                            on {{date('d M Y', strtotime($user->registration_date))}}
                                        </div>
                                    </div>
                                @endif
                                @if($item['timestamp'] <= time())
                                    <div class="row zebra-odd padding-top-10 padding-bottom-10">
                                        <div class="col-sm-12">
                                            {{$item['event']}}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@stop

@section('scriptFooter')
    <script>
        $('.nav-tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            if ($('.tab-content').height() > $('#right').height()) {
                $('#right').height($('.tab-content').height() + 50);
            }
        })
    </script>
@stop