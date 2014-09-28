@extends('layout')

@section('pageTitle')
Chapters
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Chapter Name</th>
                <th>Chapter Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $chapters as $chapter )
                <tr>
                    <td><a href="/chapter/{{{ $chapter->_id }}}/show">{{{ $chapter->chapter_name }}}{{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}}</a></td>
                    <td>{{{ $chapter->chapter_type }}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@stop
