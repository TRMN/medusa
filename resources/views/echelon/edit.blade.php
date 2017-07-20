@extends('layout')

@section('pageTitle')
    Edit {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
@stop

@section('content')
    <h1>
        Editing {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}</h1>

    {!! Form::model( $chapter, [ 'route' => [ 'echelon.update', $chapter->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('chapter_name', 'Echelon Name') !!} {!! Form::text('chapter_name') !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('Chapter Type', 'Echelon Type') !!} {!! Form::select('chapter_type', $chapterTypes, $chapter->chapter_type, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('hull_number', 'Echelon Designation') !!} {!! Form::text('hull_number') !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('Assigned To', 'Assigned To') !!} {!! Form::select('assigned_to', $chapterList, $chapter->assigned_to, ['class' => 'selectize']) !!}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('commission_date', 'Creation Date') !!}  {!!Form::date('commission_date')!!}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('decommission_date', 'Deactivation Date') !!}
            @if($numCrew > 0)
                <p>Unable to set the deactivation date as there are members or other echelons still assigned
                    to {!!$chapter->chapter_name!!}</p>
            @else
                {!!Form::date('decommission_date')!!}
            @endif

        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!!Form::checkbox('joinable', true) !!} New members and transfers may select this unit
        </div>
    </div>

    <a class="button" href="{!! URL::previous() !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'button' ] ) !!}
    {!! Form::close() !!}
@stop
