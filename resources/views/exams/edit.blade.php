@extends('layout')

@section('pageTitle')
    Edit {!!$exam->exam_id!!}'s description
@stop

@section('content')
    <h2>Edit {!!$exam->exam_id!!}'s description</h2>

    {!! Form::model( $exam, [ 'route' => 'exam.updateExam'] ) !!}
    {!! Form::hidden('id', $exam->id) !!}
    <div class="row">
        <div class="col-sm-2  ninety Incised901Light">
            {!! Form::label('name', 'Exam Description') !!}
        </div>
        <div class="col-sm-4  ninety Incised901Light ">
            {!! Form::text('name') !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::checkbox('enabled') !!} Exam Enabled
        </div>
    </div>


    <a class="btn round"
       href="{!! URL::previous() !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'btn round' ] ) !!}
    {!! Form::close() !!}
@stop
