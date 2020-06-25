@extends('layout')

@section('pageTitle')
    {{ $title }}
@stop

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">{{ $title }}</h1>

        @foreach($results as $result)
            <div class="row zebra-odd">
                <div class="col-sm-12">
                    {{ $result->msg }}
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-sm-12 text-center">
                <br/>
                <a href="/upload/admin" class="btn btn-primary"><span class="fa fa-backward"></span> Return to Admin
                    Page</a>
            </div>
        </div>

    </div>
@stop

@section('scriptFooter')

@stop