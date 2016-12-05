@extends('layout')

@section('pageTitle')
    Edit OAuth Client
@stop

@section('content')
    <h2>Edit OAuth Client</h2>

    {{ Form::model( $oauthclient, [ 'route' => [ 'oauthclient.update', $oauthclient->_id ], 'method' => 'put' ] ) }}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('client_id', 'Client ID') }} {{ Form::text('client_id') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('client_secret', 'Client Key/Secret') }} {{ Form::text('client_secret') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('client_name', 'Client Name') }} {{ Form::text('client_name') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {{ Form::label('redirect_url', 'Redirect URL') }} {{ Form::text('redirect_url') }}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            <a class="button round"
       href="{{ URL::previous() }}">Cancel</a>
            {{ Form::submit( 'Save', [ 'class' => 'button round'] ) }}
            {{ Form::close() }}
        </div>
    </div>
@stop
