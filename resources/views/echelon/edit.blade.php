@extends('layout')

@section('pageTitle')
    Edit {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
@stop

@section('content')
    <h1>
        Editing {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}</h1>

    {!! Form::model( $chapter, [ 'route' => [ 'echelon.update', $chapter->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('chapter_name', 'Echelon Name') !!} {!! Form::text('chapter_name', !empty($chapter->chapter_name)?$chapter->chapter_name: null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('Chapter Type', 'Echelon Type') !!} {!! Form::select('chapter_type', $chapterTypes, $chapter->chapter_type, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('hull_number', 'Echelon Designation') !!} {!! Form::text('hull_number', !empty($chapter->hull_number)?$chapter->hull_number: null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('Assigned To', 'Assigned To') !!} {!! Form::select('assigned_to', $chapterList, $chapter->assigned_to, ['class' => 'selectize']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('commission_date', 'Creation Date') !!}  {!!Form::date('commission_date', !empty($chapter->commission_date)?$chapter->commission_date: null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('decommission_date', 'Deactivation Date') !!}
            @if($numCrew > 0)
                <p>Unable to set the deactivation date as there are members or other echelons still assigned
                    to {!!$chapter->chapter_name!!}</p>
            @else
                {!!Form::date('decommission_date', !empty($chapter->decommission_date)?$chapter->decommission_date: null, ['class' => 'form-control'])!!}
            @endif

        </div>
    </div>

    <br/>
    <a class="btn btn-warning" href="{!! URL::previous() !!}"><span class="fa fa-times"></span> Cancel </a>
    <button type="submit" class="btn btn-success"><span class="fa fa-save"><span
                    class="Incised901Light"> Save </span></span></button>
    {!! Form::close() !!}
@stop
