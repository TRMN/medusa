@extends('layout')

@section('pageTitle')
    Create an Echelon
@stop

@section('content')
    <h2>Create an Echelon</h2>

    {!! Form::model( $chapter, [ 'route' => [ 'echelon.store' ] ] ) !!}
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('chapter_name', 'Echelon Name') !!} {!! Form::text('chapter_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('branch', "Branch") !!} {!! Form::select('branch', $branches, null, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('chapter_type', 'Echelon Type') !!} {!! Form::select('chapter_type', $chapterTypes, null, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('hull_number', 'Echelon Designation') !!} {!! Form::text('hull_number', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('assigned_to', 'Assigned To') !!} {!! Form::select('assigned_to', $fleets, null, ['class' => 'selectize']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('commission_date', 'Creation Date (if appropriate)') !!}  {!!Form::date('commission_date', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('decommision_date', 'Deactivation Date (if appropriate)') !!}  {!!Form::date('decomission_date', null, ['class' => 'form-control'])!!}
        </div>
    </div>


    <button type="submit" class="btn btn-success"><span class="fa fa-save"><span
                    class="Incised901Light"> Save </span></span></button>

    {!! Form::close() !!}
@stop
