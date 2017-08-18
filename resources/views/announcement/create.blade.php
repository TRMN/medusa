@extends('layout')

@section('pageTitle')
    New Announcement
@stop

@section('content')
    <h1>Create New Announcement</h1>
    {!! Form::model('announcement', [ 'route' => [ 'announcement.store' ] ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('summary', 'Summary') !!} {!! Form::text('summary') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('body', 'Message') !!} {!! Form::textarea('body') !!}
        </div>
    </div>
    <p>Note: this announcement will not be published immediately when you save.</p>
    {!! Form::submit('Save', [ 'class' => 'btn' ]) !!}
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
