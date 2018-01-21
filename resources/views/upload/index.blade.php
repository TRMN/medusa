@extends('layout')

@section('pageTitle')
    {{ $title }}
@stop

@section('dochead')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all"
          rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">{{ $title }}</h1>

        <div class="row text-center">
            <div class="col-sm-5">
                {{Form::open(['url' => '/upload/file', 'id'=> 'file-upload', 'files' => true])}}
                <input type="hidden" name="method" value="{{ $method }}">
                <input type="hidden" name="source" value="{{ $source }}">
                @if($hidden)
                    @foreach($hidden as $key => $value)
                        <input type="hidden" name="{{$key}}" value="{{$value}}">
                    @endforeach
                @endif
                <div class="file-loading">
                    <input type="file" name="file" id="file" accept="{{ $accept }}">
                </div>
                {{Form::close()}}
            </div>
        </div>

        @if($method == 'processSheet')
            <div class="row">
                <div class="col-sm-5 text-left">
                    <br/>
                    <a href="{{route('chapter.show', [$hidden['chapter']])}}" class="btn btn-primary"><span
                                class="fa fa-arrow-left"></span> Return to roster</a>
                </div>
            </div>
        @endif
    </div>
@stop

@section('scriptFooter')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/themes/fa/theme.min.js"></script>
    <script type="text/javascript">
        $(
            $('#file').fileinput({
                    theme: "fa",
                    hiddenThumbnailContent: true,
                    showPreview: false
                }
            )
        );
    </script>
@stop