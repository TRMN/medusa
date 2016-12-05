@extends('layout')

@section('pageTitle')
    Edit {!!$exam->exam_id!!}'s description
@stop

@section('content')
    <h2>Edit {!!$exam->exam_id!!}'s description</h2>

    {!! Form::model( $exam, [ 'route' => 'exam.updateExam'] ) !!}
    {!! Form::hidden('id', $exam->id) !!}
    <div class="row">
        <div class="small-2 columns ninety Incised901Light">
            {!! Form::label('name', 'Exam Description') !!}
        </div>
        <div class="small-4 columns ninety Incised901Light end">
            {!! Form::text('name') !!}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::checkbox('enabled') !!} Exam Enabled
        </div>
    </div>


    <a class="button round"
       href="{!! URL::previous() !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'button round' ] ) !!}
    {!! Form::close() !!}
@stop
