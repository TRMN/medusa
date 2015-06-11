@extends('layout')

@section('pageTitle')
Create Ship
@stop

@section('content')
<h1>Create New Ship</h1>
{{ Form::model( $ship, [ 'route' => [ 'ship.store' ] ] ) }}
<div class="form-group">
    {{ Form::label('title', 'Title') }} {{ Form::text('title') }}
</div>
<div class="form-group">
    {{ Form::label('co', 'Commanding Officer') }} {{ Form::select('co', $users) }}
</div>
<div class="form-group">
    {{ Form::label('xo', 'Executive Officer') }} {{ Form::select('xo', $users) }}
</div>
<div class="form-group">
    {{ Form::label('bosun', 'Bosun') }} {{ Form::select('bosun', $users) }}
</div>
{{ Form::submit('Save') }}
{{ Form::close() }}
@stop