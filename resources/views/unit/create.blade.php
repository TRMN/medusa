@extends('layout')

@section('pageTitle')
    Stand-up {!!$title!!}
@stop

@section('dochead')
    <style>
        ::-webkit-input-placeholder {
            color: #66b2c9;
        }

        :-moz-placeholder {
            color: #66b2c9;
        }

        ::-moz-placeholdermoz-placeholder {
            color: #66b2c9;
        }

        ::-ms-input-placeholder {
            color: #66b2c9;
        }

        ::placeholder {
            color: #66b2c9;
        }

        .selectize-input,
        .selectize-input input {
            color: whitesmoke;
        }

        .selectize-dropdown,
        .selectize-input,
        .selectize-control.single .selectize-input,
        .selectize-control.single .selectize-input.input-active {
            background: #1c1c1d;
            color:  whitesmoke;
        }

        .selectize-control.single .selectize-input,
        .selectize-dropdown.single {
            border-color: #29292a;
        }

        .selectize-control.single .selectize-input {
            padding: 2px 30px 2px 5px;
        }

        .selectize-control.single .selectize-input:after {
            border-top-color: whitesmoke;
        }

        .selectize-dropdown .active {
            color: #1c1c1d;
            background-color: #66b2c9;
        }

        .selectize-input .item {
            max-width: 95%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            margin-top: 0.60rem;
        }

        .selectize-input {
            min-height: 2.6875rem;
        }
    </style>
@stop

@section('content')
<h2>Stand-up {!!$title!!}</h2>

{!! Form::model( $chapter, [ 'route' => [ $route . '.store' ] ] ) !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('chapter_name', 'Command or Unit Name') !!} {!! Form::text('chapter_name') !!}
        </div>
</div>
{!! $branches !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('chapter_type', 'Command/Unit Type') !!} {!! Form::select('chapter_type', $chapterTypes, null, ['class' => 'selectize']) !!}
        </div>
</div>
<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('hull_number', 'Command/Unit Designation') !!} {!! Form::text('hull_number') !!}
        </div>
    </div>
<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
        {!! Form::label('assigned_to', 'Assigned To') !!} {!! Form::select('assigned_to', $commands, null, ['class' => 'selectize']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
        {!! Form::label('commission_date', 'Stand-up Date (if appropriate') !!}  {!!Form::date('commission_date')!!}
    </div>
</div>

<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
        {!!Form::checkbox('joinable', true, true) !!} New members and transfers may select this unit
    </div>
</div>

{!! Form::submit( 'Save', [ 'class' => 'btn round'] ) !!}
{!! Form::close() !!}
@stop
