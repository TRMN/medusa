@extends('layout')

@section('pageTitle')
    Decommision Ship
@stop

@section('content')
    <h1>Confirm Ship Decommissioning</h1>

    @if($numCrew == 0)
        <p>Are you sure you want to decommission {!!$chapter->chapter_name!!}?  The decommission date will be set to today.</p>
        {!! Form::model( $chapter, [ 'route' => [ 'chapter.destroy', $chapter->id ], 'method' => 'delete' ] ) !!}
        {!! Form::submit('Decommission ' . $chapter->chapter_name, ['class' => 'btn']) !!}
        {!! Form::close() !!}
    @else
        <p>Unable to decommission {!!$chapter->chapter_name!!} at this time because there are still members assigned to it.</p>
        <a href="{!!route('chapter.index')!!}" class="btn">Return to Ship List</a>
    @endif
@stop