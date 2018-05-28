@extends('layout')

@section('pageTitle')
    Edit a Billet
@stop

@section('content')
    <h2>Edit a Billet</h2>

    {!! Form::model( $billet, [ 'route' => [ 'billet.update', $billet->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('billet_name', 'Billet Name') !!} {!! Form::text('billet_name', $billet->billet_name, ['class' => 'form-control']) !!}
            {!!Form::hidden('old_name', $billet->billet_name)!!}
        </div>
    </div>




    <br/>
    <div class="row">
        <div class="col-sm-6 Incised901Light text-center">
            <a class="btn btn-warning"
               href="{!! URL::previous() !!}"><span class="fa fa-times"></span> Cancel </a> <button type="submit" class="btn btn-success"><span class="fa fa-save"><span
                            class="Incised901Light"> Save </span></span></button>
        </div>
    </div>
    {!! Form::close() !!}
@stop
