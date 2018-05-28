@extends('layout')

@section('pageTitle')
    Full Ribbon Display
@stop

@section('content')
        <div class="plastron">
        {{--<div class="row">--}}
            {{--<div class=" col-sm-3">--}}
                @if(in_array($user->branch, ['RMN', 'RMMC', 'RMA']))
                    <div class="stripes">
                        @if(file_exists(public_path('patches/' . $user->branch . '.svg')))
                            <img src="{!!asset('patches/' . $user->branch . '.svg')!!}" alt="{!!$user->branch!!}"
                                 data-toggle="tooltip" title="{!!$user->branch!!}" class="branch">
                        @endif
                        @foreach($user->getRibbons('RS') as $ribbon)
                            <img src="{!!asset('awards/stripes/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
                                 alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}"
                                 class="{!!$ribbon['code']!!}">
                        @endforeach
                    </div>
                @endif
            {{--</div>--}}
            {{--<div class=" col-sm-3">--}}
                <div class="name-badge-wrapper">
                    <div class="name-badge-spacer">&nbsp;</div>
                    <div class="name-badge">{{$user->last_name}}, {{substr($user->first_name, 0 , 1)}}</div>
                    <div class="name-badge-spacer">&nbsp;</div>
                    <br/>
                    @foreach($user->getRibbons('R') as $index => $ribbon)
                        <img src="{!!asset('ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
                             alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="citation">
                    @endforeach
                </div>
            {{--</div>--}}
            {{--<div class=" col-sm-3">--}}
                <div class="ribbons">
                    @foreach($user->getRibbons('TL') as $ribbon)
                        @if($ribbon['code'] == 'HS')
                            @for ($i = 0; $i < $ribbon['count']; $i++)
                                <img src="{!!asset('awards/badges/' . $ribbon['code'] . '-1.svg')!!}"
                                     alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}"
                                     class="{!!$ribbon['code']!!}">
                            @endfor
                        @else
                            <img src="{!!asset('awards/badges/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
                                 alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}"
                                 class="{!!$ribbon['code']!!}">
                        @endif
                        <br/>
                    @endforeach
                    @foreach($user->getRibbons('L') as $index => $ribbon)
                        <img src="{!!asset('ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
                             alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}"
                             class="ribbon">@if($user->leftRibbonCount % 3 === $index)<br/>
                        @endif
                    @endforeach
                </div>
            {{--</div>--}}
            {{--<div class=" col-sm-3">--}}
                @if((!empty($user->unitPatchPath) && file_exists(public_path($user->unitPatchPath))) || $user->getRibbons('LS'))
                    <div class="unit">
                        @foreach($user->getRibbons('LS') as $ribbon)
                            <img src="{!!asset('images/' . $ribbon['code'] . '.svg')!!}" alt="{!!$ribbon['name']!!}"
                                 data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}">
                        @endforeach
                        @if(!empty($user->unitPatchPath) && file_exists(public_path($user->unitPatchPath)))
                            <img src="{!!asset($user->unitPatchPath)!!}"
                                 class="patch{!!$user->getRibbons('LS')?' patch-with-unc' : ''!!}"><br/>
                        @endif
                    </div>
                @endif
            </div>
        {{--</div>--}}
    {{--</div>--}}

@stop