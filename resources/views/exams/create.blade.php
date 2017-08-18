@extends('layout')

@section('pageTitle')
    Add Exam to List
@stop

@section('content')
    <h2>Add Exam to List</h2>

    {!! Form::open( [ 'route' => 'exam.store' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('name', 'Exam Name') !!} {!! Form::text('name') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('exam_id', 'Exam ID') !!} {!! Form::text('exam_id') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::submit( 'Save', [ 'class' => 'btn round'] ) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop
