@extends('layout')

@section('pageTitle')
    Edit OAuth Client
@stop

@section('content')
    <h2>Edit OAuth Client</h2>

    {!! Form::model( $oauthclient, [ 'route' => [ 'oauthclient.update', $oauthclient->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('client_id', 'Client ID') !!} {!! Form::text('client_id') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('secret', 'Client Key/Secret') !!} {!! Form::text('secret') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('name', 'Client Name') !!} {!! Form::text('name') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('redirect', 'Redirect URL') !!} {!! Form::text('redirect') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            <a class="btn round"
               href="{!! URL::previous() !!}">Cancel</a>
            {!! Form::submit( 'Save', [ 'class' => 'btn round'] ) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop
