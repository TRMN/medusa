@extends('layout')

@section('pageTitle')
    Promotion Point Upload Status for {{$chapter_name}}
@stop

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Promotion Point Upload Status for {{$chapter_name}}</h1>

        @if(is_null($log))
            <div class="row">
                <div class="col-sm-12 text-center Incised901Light">
                    No spreadsheets have been uploaded yet
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-sm-12 text-center"><h2>Files for {{$log['chapter_name']}}</h2></div>
            </div>
            <div class="row bottom-border">
                <div class="col-sm-8 nowrap text-left">File</div>
                <div class="col-sm-4 nowrap text-left">Status</div>
            </div>

            @foreach($log['files'] as $file)
                <div class="row zebra-even bottom-border">
                    <div class="col-sm-8 nowrap text-left border-right">{{$file['original_name']}}</div>
                    <div class="col-sm-4 nowrap text-left">{{$file['current_status']}} {{date("F j, Y @ g:i a", $file['status_ts'])}}</div>
                </div>

            @endforeach
        @endif

        <div class="row">
            <div class="col-sm-12 text-left">
                <br />
                <a href="{{route('chapter.show', [$log['chapter_id']])}}" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Return to roster</a>
            </div>
        </div>
    </div>
@stop

@section('scriptFooter')

@stop