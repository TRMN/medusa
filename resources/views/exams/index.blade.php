@extends('layout')

@section('pageTitle')
    Upload Exam Records
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1 class="text-center">Upload Exam Records</h1>
    <div class="text-center">
        {!! Form::open(['route' => 'exam.upload', 'method' => 'post', 'files' => true]) !!}
        {!!Form::file('file')!!}
        {!!Form::submit('Upload Grades', ['class' => 'btn round', 'id' => 'uploadGrades'])!!}
        {!! Form::close() !!}
    </div>
    @if(!empty($messages))
        @foreach($messages as $line)
            <div class="row">
                <div class=" col-sm-12 @if($line->severity == 'info') green @else red @endif">
                    {!!$line->msg!!}
                </div>
            </div>
        @endforeach
    @endif
    <div class="wait"></div>
@stop