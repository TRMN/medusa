@extends('layout')

@section('pageTitle')
 Edit {{ $chapter->chapter_name }}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
@stop

@section('content')
    <h1>
        Editing {{ $chapter->chapter_name }}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}</h1>

    {{ Form::model( $chapter, [ 'route' => [ $route . '.update', $chapter->_id ], 'method' => 'put' ] ) }}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('chapter_name', 'Command or Unit Name') }} {{ Form::text('chapter_name') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('Chapter Type', 'Command/Unit Type') }} {{ Form::select('chapter_type', $chapterTypes, $chapter->chapter_type) }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('hull_number', 'Command/Unit Designation') }} {{ Form::text('hull_number') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('Assigned To', 'Assigned To') }} {{ Form::select('assigned_to', $chapterList, $chapter->assigned_to) }}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('commission_date', 'Stand-up Date') }}  {{Form::date('commission_date')}}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('decommission_date', 'Stand-down Date') }}
            @if($numCrew > 0)
                <p>Unable to set the stand-down date as there are members, other commands or units still assigned to {{$chapter->chapter_name}}</p>
            @else
                {{Form::date('decommission_date')}}
            @endif

        </div>
    </div>

    <a class="button" href="{{ URL::previous() }}">Cancel</a> {{ Form::submit( 'Save', [ 'class' => 'button' ] ) }}
    {{ Form::close() }}
@stop
