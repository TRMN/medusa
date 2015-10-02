@extends('layout')

@section('pageTitle')
Create a Billet
@stop

@section('content')
<h2>Create a Billet</h2>

{{ Form::model( $billet, [ 'route' => [ 'billet.store' ] ] ) }}
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('billet_name', 'Billet Name') }} {{ Form::text('billet_name') }}
    </div>
</div>


{{ Form::submit( 'Save', [ 'class' => 'button round'] ) }}
{{ Form::close() }}
@stop
