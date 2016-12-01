@extends('layout')

@section('pageTitle')
    Service Record
@stop

@section('content')
    @include('partials.servicerecord', ['user' => $user, 'permsObj' => $permsObj, 'ptitles' => $ptitles, 'korders' => $korders])
@stop
