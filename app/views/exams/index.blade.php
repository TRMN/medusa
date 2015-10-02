@extends('layout')

@section('pageTitle')
    Upload Exam Records
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1 class="text-center">Upload Exam Records</h1>
    <div class="text-center">
        {{ Form::open(['route' => 'exam.upload', 'method' => 'post', 'files' => true]) }}
        {{Form::file('file')}}
        {{Form::submit('Upload Grades', ['class' => 'button round', 'id' => 'uploadGrades'])}}
        {{ Form::close() }}
    </div>
    <div class="wait"></div>
@stop