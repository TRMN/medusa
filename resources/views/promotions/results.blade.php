@extends('layout')

@section('pageTitle')
    Promotion results for {{ $chapter->chapter_name }}
@stop

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Promotion results for {{ $chapter->chapter_name }}</h1>

        <div class="row">As of {{ date('d M Y') }}, the following individuals are promoted to the ranks indicated.</div>
<br /><br />

            @foreach($promotions as $promotion)
                <div class="row">
                    {{$promotion['from']}} {{$promotion['name']}} ({{$promotion['member_id']}}) to {{$promotion['to']}}
                </div>
            @endforeach
    </div>
@stop

@section('scriptFooter')

@stop