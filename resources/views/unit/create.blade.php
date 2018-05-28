@extends('layout')

@section('pageTitle')
    Stand-up {!!$title!!}
@stop

@section('content')
<h2>Stand-up {!!$title!!}</h2>

{!! Form::model( $chapter, [ 'route' => [ $route . '.store' ] ] ) !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
    {!! Form::label('chapter_name', 'Command or Unit Name') !!} {!! Form::text('chapter_name', null, ['class' => 'form-control']) !!}
        </div>
</div>
{!! $branches !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
    {!! Form::label('chapter_type', 'Command/Unit Type') !!} {!! Form::select('chapter_type', $chapterTypes, null, ['class' => 'selectize']) !!}
        </div>
</div>
<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
    {!! Form::label('hull_number', 'Command/Unit Designation') !!} {!! Form::text('hull_number', null, ['class' => 'form-control']) !!}
        </div>
    </div>
<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
        {!! Form::label('assigned_to', 'Assigned To') !!} {!! Form::select('assigned_to', $commands, null, ['class' => 'selectize']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
        {!! Form::label('commission_date', 'Stand-up Date (if appropriate') !!}  {!!Form::date('commission_date', null, ['class' => 'form-control'])!!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6  ninety Incised901Light form-group">
        {!!Form::checkbox('joinable', true, true) !!} New members and transfers may select this unit
    </div>
</div>

<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong> </button>
{!! Form::close() !!}
@stop
