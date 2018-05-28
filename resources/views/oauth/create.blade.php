@extends('layout')

@section('pageTitle')
    Add OAuth Client
@stop

@section('content')
    <h2>Add OAuth Client</h2>

    {!! Form::open( [ 'route' => 'oauthclient.store' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('client_id', 'Client ID') !!} {!! Form::text('client_id', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('secret', 'Client Key/Secret') !!} {!! Form::text('secret', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('name', 'Client Name') !!} {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group">
            {!! Form::label('redirect', 'Redirect URL') !!} {!! Form::text('redirect', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light form-group text-center">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong> </button>
            {!! Form::close() !!}
        </div>
    </div>
@stop
