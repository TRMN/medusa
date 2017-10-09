@extends('layout')

@section('pageTitle')
    Add Course to List
@stop

@section('content')
    <h2>Add Course to List</h2>

    {!! Form::open( [ 'route' => 'exam.store' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('name', 'Course Name') !!} {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('exam_id', 'Course ID') !!} {!! Form::text('exam_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group text-center">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong> </button>
            {!! Form::close() !!}
        </div>
    </div>
@stop
