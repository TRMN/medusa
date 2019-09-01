@extends('layout')

@section('pageTitle')
    Edit {!! $chapter->chapter_name !!} @if (empty($chapter->hull_number) === false) ({!! $chapter->hull_number !!}) @endif
@stop

@section('content')
    <h1>
        Editing {!! $chapter->chapter_name !!} @if (empty($chapter->hull_number) === false) ({!! $chapter->hull_number !!}
        ) @endif</h1>

    {!! Form::model( $chapter, [ 'route' => [ $route . '.update', $chapter->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('chapter_name', 'Command or Unit Name') !!} {!! Form::text('chapter_name', $chapter->chapter_name, ['class' => 'form-control']) !!}
        </div>
    </div>
    {!! $branches !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('Chapter Type', 'Command/Unit Type') !!} {!! Form::select('chapter_type', $chapterTypes, $chapter->chapter_type, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('hull_number', 'Command/Unit Designation') !!} {!! Form::text('hull_number', $chapter->hull_number, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('Assigned To', 'Assigned To') !!} {!! Form::select('assigned_to', $chapterList, $chapter->assigned_to, ['class' => 'selectize']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('commission_date', 'Stand-up Date') !!}  {!!Form::date('commission_date', $chapter->commission_date, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('decommission_date', 'Stand-down Date') !!}
            @if($numCrew > 0)
                <p>Unable to set the stand-down date as there are members, other commands or units still assigned
                    to {!!$chapter->chapter_name!!}</p>
            @else
                {!!Form::date('decommission_date', $chapter->decommission_date, ['class' => 'form-control'])!!}
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!!Form::checkbox('joinable', true, $chapter->joinable) !!} New members and transfers may select this unit
        </div>
        </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light text-center">
            <a class="btn btn-warning" href="{!! URL::previous() !!}"><span class="fa fa-times"></span> Cancel </a>
            <button type="submit" class="btn btn-success"><span class="fa fa-save"><span
                            class="Incised901Light"> Save </span></span></button>
    </div>
    </div>
    {!! Form::close() !!}
@stop
