@extends('layout')

@section('pageTitle')
Create a Chapter Type
@stop

@section('content')
<h2>Create a Chapter Type</h2>

{!! Form::open( [ 'route' => [ 'type.store' ] ] ) !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
    {!! Form::label('chapter_type', 'Chapter Type') !!} {!! Form::text('chapter_type', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
    {!! Form::label('chapter_description', 'Chapter Description') !!} {!! Form::text('chapter_description', null, ['class' => 'form-control']) !!}
    </div>
</div>

<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong> </button>
{!! Form::close() !!}
@stop
