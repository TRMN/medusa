@extends('layout')

@section('pageTitle')
Create a Billet
@stop

@section('content')
<h2>Create a Billet</h2>

{!! Form::open( [ 'route' => [ 'billet.store' ] ] ) !!}
<div class="row form-group">
    <div class="col-sm-6  ninety Incised901Light ">
    {!! Form::label('billet_name', 'Billet Name') !!} {!! Form::text('billet_name', null, ['class' => 'form-control']) !!}
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
