@extends('layout')

@section('pageTitle')
    Add Exam to List
@stop

@section('content')
    <h2>Add Exam to List</h2>

    {{ Form::open( [ 'route' => 'exam.store' ] ) }}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('name', 'Exam Name') }} {{ Form::text('name') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('exam_id', 'Exam ID') }} {{ Form::text('exam_id') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::submit( 'Save', [ 'class' => 'button round'] ) }}
            {{ Form::close() }}
        </div>
    </div>
@stop
