@extends('layout')

@section('pageTitle')
Create an Echelon
@stop

@section('content')
<h2>Create an Echelon</h2>

{!! Form::model( $chapter, [ 'route' => [ 'echelon.store' ] ] ) !!}
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('chapter_name', 'Echelon Name') !!} {!! Form::text('chapter_name') !!}
        </div>
</div>
<div class="row">
    <div class="end small-6 columns ninety Incised901Light end">
        {!! Form::label('branch', "Branch") !!} {!! Form::select('branch', $branches) !!}
    </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('chapter_type', 'Echelon Type') !!} {!! Form::select('chapter_type', $chapterTypes) !!}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {!! Form::label('hull_number', 'Echelon Designation') !!} {!! Form::text('hull_number') !!}
        </div>
    </div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!! Form::label('assigned_to', 'Assigned To') !!} {!! Form::select('assigned_to', $fleets) !!}
    </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!! Form::label('commission_date', 'Creation Date (if appropriate)') !!}  {!!Form::date('commission_date')!!}
    </div>
</div>

<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!! Form::label('decommision_date', 'Deactivation Date (if appropriate)') !!}  {!!Form::date('decomission_date')!!}
    </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
        {!!Form::checkbox('joinable', true) !!} New members and transfers may select this unit
    </div>
</div>

{!! Form::submit( 'Save', [ 'class' => 'button round'] ) !!}
{!! Form::close() !!}
@stop
