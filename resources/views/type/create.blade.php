@extends('layout')

@section('pageTitle')
Create a Chapter Type
@stop

@section('content')
<h2>Create a Chapter Type</h2>

{!! Form::open( [ 'route' => [ 'type.store' ] ] ) !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('chapter_type', 'Chapter Type') !!} {!! Form::text('chapter_type') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('chapter_description', 'Chapter Description') !!} {!! Form::text('chapter_description') !!}
    </div>
</div>

{!! Form::submit( 'Save', [ 'class' => 'btn round'] ) !!}
{!! Form::close() !!}
@stop
