@extends('layout')

@section('pageTitle')
    Authorization Request From {!!$client->client_name!!}
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-2 text-center">
            <img src="{!!asset('images/project-medusa.svg')!!}" width="150px" height="150px">
        </div>
        <div class=" col-sm-4 " Incised901Light">
            <h3>An application would like to connect to your account</h3>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 " Incised901Light">
            <p><br/>The application <span class="Incised901Bold">{!!$client->client_name!!}</span> wants to access your
                basic information (name, email address, city, state/province, country and your profile picture).
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 " Incised901Light text-center">
            <h3>Allow <span class="Incised901Bold">{!!$client->client_name!!}</span> access?</h3>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 " Incised901Light text-center">
            <form method="post" action="/oauth/authorize">
                {{ csrf_field() }}

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <button type="submit" class="btn">Approve</button>
            </form>

            <form method="post" action="/oauth/authorize">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <button class="btn">Deny</button>
            </form>
        </div>
    </div>
@stop
