@extends('layout')

@section('pageTitle')
    Deactivate Echelon
@stop

@section('content')
    <h1>Confirm Echelon Deactivation</h1>

    @if($numCrew == 0)
        <p>Are you sure you want to deactive {!!$chapter->chapter_name!!}? The deactivation date will be set to
            today.</p>
        {!! Form::model( $chapter, [ 'route' => [ 'echelon.destroy', $chapter->id ], 'method' => 'delete' ] ) !!}
        {!! Form::submit('Decommission ' . $chapter->chapter_name, ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    @else
        <p>Unable to deactivation {!!$chapter->chapter_name!!} as there are members or other echelons still assigned
            to it</p>
        <a href="{!!route('chapter.index')!!}" class="btn btn-danger">Return to Ship List</a>
    @endif
@stop