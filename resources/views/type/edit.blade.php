@extends('layout')

@section('pageTitle')
    Edit a Chapter Type
@stop

@section('content')
    <h2>Editing {!!$type->chapter_description!!}</h2>

    {!! Form::model( $type, [ 'route' => [ 'type.update', $type->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('chapter_type', 'Chapter Type') !!} {!! Form::text('chapter_type') !!}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('chapter_description', 'Chapter Description') !!} {!! Form::text('chapter_description') !!}
        </div>
    </div>

    <a class="button" href="{!! URL::previous() !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'button round'] ) !!}
    {!! Form::close() !!}
@stop