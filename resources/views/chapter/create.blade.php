@extends('layout')

@section('pageTitle')
Commission a Ship
@stop

@section('content')
<h2>Commission a Ship</h2>

{!! Form::model( $chapter, [ 'route' => [ 'chapter.store' ] ] ) !!}
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('chapter_name', 'Chapter Name') !!} {!! Form::text('chapter_name') !!}
        </div>
</div>
<div class="row">
    <div class="end small-6 columns ninety Incised901Light end">
        {!! Form::label('branch', "Branch") !!} {!! Form::select('branch', $branches, null, ['class' => 'selectize']) !!}
    </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('chapter_type', 'Chapter Type') !!} {!! Form::select('chapter_type', $chapterTypes, null, ['class' => 'selectize']) !!}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('hull_number', 'Hull Number') !!} {!! Form::text('hull_number') !!}
        </div>
    </div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('ship_class', 'Ship Class') !!} {!! Form::text('ship_class') !!}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!! Form::label('assigned_to', 'Assigned To') !!} {!! Form::select('assigned_to', $fleets, null, ['class' => 'selectize']) !!}
    </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!! Form::label('commission_date', 'Commission Date (if appropriate)') !!}  {!!Form::date('commission_date')!!}
    </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!! Form::label('decommision_date', 'Decomission Date (if appropriate)') !!}  {!!Form::date('decomission_date')!!}
    </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!!Form::checkbox('joinable', true, true) !!} New members and transfers may select this unit
    </div>
</div>

{!! Form::submit( 'Save', [ 'class' => 'button round'] ) !!}
{!! Form::close() !!}
@stop
