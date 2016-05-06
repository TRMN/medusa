@extends('layout')

@section('pageTitle')
Create an Exam
@stop

@section('content')
<h2>Create an Exam</h2>

{{ Form::open( [ 'route' => [ 'exam.store' ] ] ) }}
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('exam_name', 'Exam Name') }} {{ Form::text('exam_name') }}
    {{ Form::label('exam_id'), 'Exam ID') }} {{ Form::text('exam_id') }}
    </div>
</div>


{{ Form::submit( 'Save', [ 'class' => 'button round'] ) }}
{{ Form::close() }}
@stop
