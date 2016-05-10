@extends('layout')

@section('pageTitle')
    Edit an Exam
@stop

@section('content')
    <h2>Edit an Exam</h2>

    {{ Form::model( $exam, [ 'route' => [ 'exams.edit', $exam->_id ], 'method' => 'put' ] ) }}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('exam_name', 'Exam Name') }} {{ Form::text('exam_name') }}
            {{Form::hidden('old_name', $exam->exam_name)}}
        </div>
    </div>


    <a class="button round"
       href="{{ URL::previous() }}">Cancel</a> {{ Form::submit( 'Save', [ 'class' => 'button round' ] ) }}
    {{ Form::close() }}
@stop
