@extends('layout')

@section('pageTitle')
    Stand-up a {{$title}}
@stop

@section('content')
<h2>Stand-up a {{$title}}</h2>

{{ Form::model( $chapter, [ 'route' => [ 'unit.store' ] ] ) }}
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('chapter_name', 'Command or Unit Name') }} {{ Form::text('chapter_name') }}
        </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('chapter_type', 'Command/Unit Type') }} {{ Form::select('chapter_type', $chapterTypes) }}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('hull_number', 'Command/Unit Designation') }} {{ Form::text('hull_number') }}
        </div>
    </div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {{ Form::label('assigned_to', 'Assigned To') }} {{ Form::select('assigned_to', $commands) }}
    </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {{ Form::label('commission_date', 'Stand-up Date (if appropriate') }}  {{Form::date('commission_date')}}
    </div>
</div>

{{ Form::submit( 'Save', [ 'class' => 'button round'] ) }}
{{ Form::close() }}
@stop
