@extends('layout')

@section('pageTitle')
    Editing "{!! $announcement->summary !!}"
@stop

@section('content')
    <h1>Edit {!! $announcement->summary !!}</h1>
    {!! Form::model( $announcement, [ 'route' => [ 'announcement.update', $announcement->id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('summary', 'Summary') !!} {!! Form::text('summary') !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('is_published', 'Publish') !!} {!! Form::select('is_published', $announcement->getPublishLabels(), $announcement->is_published ) !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('body', 'Message') !!} {!! Form::textarea('body') !!}
        </div>
    </div>
    <p>Note: this announcement will not be published immediately when you save.</p>
    <a class="button"
       href="{!! route( 'announcement.index' ) !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'button' ])  !!}
    {!! Form::close() !!}
@stop

@section('scriptFooter')
    <script src="//cdn.ckeditor.com/4.4.5/basic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('body');
        });
    </script>
@stop