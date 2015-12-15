@extends('layout')

@section('pageTitle')
    Edit a Billet
@stop

@section('content')
    <h2>Edit a Billet</h2>

    {{ Form::model( $billet, [ 'route' => [ 'billet.update', $billet->_id ], 'method' => 'put' ] ) }}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('billet_name', 'Billet Name') }} {{ Form::text('billet_name') }}
            {{Form::hidden('old_name', $billet->billet_name)}}
        </div>
    </div>


    <a class="button round"
       href="{{ URL::previous() }}">Cancel</a> {{ Form::submit( 'Save', [ 'class' => 'button round' ] ) }}
    {{ Form::close() }}
@stop
