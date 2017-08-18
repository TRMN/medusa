@extends('layout')

@section('pageTitle')
Create a Billet
@stop

@section('content')
<h2>Create a Billet</h2>

{!! Form::open( [ 'route' => [ 'billet.store' ] ] ) !!}
<div class="row">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('billet_name', 'Billet Name') !!} {!! Form::text('billet_name') !!}
    </div>
</div>


{!! Form::submit( 'Save', [ 'class' => 'btn round'] ) !!}
{!! Form::close() !!}
@stop
