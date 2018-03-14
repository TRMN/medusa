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
    <br />
    <br />
    <div class="text-center">
        <a href="{{ route('promotions', [$chapter->id]) }}" class="btn btn-primary"><span class="fa fa-thumbs-up"></span> Return to Promotions</a> <a href="{{route('chapter.show', [$chapter->id])}}" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Return to Roster</a>
    </div>
@stop

@section('scriptFooter')

@stop