@extends('layout')

@section('pageTitle')
    Commission a Ship
@stop

@section('content')
    <h2>Commission a Ship</h2>

    {!! Form::model( $chapter, [ 'route' => [ 'chapter.store' ] ] ) !!}
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('chapter_name', 'Chapter Name') !!} {!! Form::text('chapter_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 Incised901Light form-group">
            {!! Form::label('branch', "Branch") !!} {!! Form::select('branch', $branches, null, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('chapter_type', 'Chapter Type') !!} {!! Form::select('chapter_type', $chapterTypes, null, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('hull_number', 'Hull Number') !!} {!! Form::text('hull_number', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('ship_class', 'Ship Class') !!} {!! Form::text('ship_class', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('assigned_to', 'Assigned To') !!} {!! Form::select('assigned_to', $fleets, null, ['class' => 'selectize']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('commission_date', 'Commission Date (if appropriate)') !!}  {!!Form::date('commission_date', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light">
            {!!Form::checkbox('joinable', true, true) !!} New members and transfers may select this unit
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-sm-6 Incised901Light text-center">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"><span
                            class="Incised901Light"> Save </span></span></button>
        </div>
    </div>


    {!! Form::close() !!}
@stop
