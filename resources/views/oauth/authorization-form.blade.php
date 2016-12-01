@extends('layout')

@section('pageTitle')
    Authorization Request From {!!$client->client_name!!}
@stop

@section('content')
    <div class="row">
        <div class="columns small-2 text-center">
            <img src="{!!asset('images/project-medusa.svg')!!}" width="150px" height="150px">
        </div>
        <div class="columns small-4 end Incised901Light">
            <h3>An application would like to connect to your account</h3>
        </div>
    </div>
    <div class="row">
        <div class="columns small-6 end Incised901Light">
            <p><br/>The application <span class="Incised901Bold">{!!$client->client_name!!}</span> wants to access your
                basic information (name, email address, city, state/province, country and your profile picture).
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class="columns small-6 end Incised901Light text-center">
            <h3>Allow <span class="Incised901Bold">{!!$client->client_name!!}</span> access?</h3>
        </div>
    </div>
    <div class="row">
        <div class="columns small-6 end Incised901Light text-center">
            {!!Form::open(['url' => '/oauth/authorize', 'method' => 'post'])!!}
            {!!Form::token()!!}
            {!!Form::hidden('client_id', $params['client_id'])!!}
            {!!Form::hidden('redirect_uri', $params['redirect_uri'])!!}
            {!!Form::hidden('response_type', $params['response_type'])!!}
            {!!Form::hidden('state', empty($params['state'])?'basic':$params['state'])!!}

            {!!Form::submit('Approve', ['name' => 'authorized', 'class' => 'button'])!!}
            {!!Form::submit('Deny', ['name' => 'authorized', 'class' => 'button'])!!}
            {!!Form::close()!!}
        </div>
    </div>
@stop
