@extends('layout')

@section('pageTitle')
    Stand-down {!!$title!!}
@stop

@section('content')
    <h1>Confirm {!!$title!!} stand-down</h1>

    @if($numCrew == 0)
        <p>Are you sure you want to stand-down {!!$chapter->chapter_name!!}?  The stand-down date will be set to today.</p>
        {!! Form::model( $chapter, [ 'route' => [ 'unit.destroy', $chapter->id ], 'method' => 'delete' ] ) !!}
        {!! Form::submit('Decommission ' . $chapter->chapter_name, ['class' => 'button']) !!}
        {!! Form::close() !!}
    @else
        <p>Unable to stand-down {!!$chapter->chapter_name!!} as there are members, commands or units still assigned
            to it</p>
        <a href="{!!route('chapter.index')!!}" class="button">Return to Ship List</a>
    @endif
@stop