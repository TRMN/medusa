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
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach( $chapters as $chapter )
                <tr>
                    <td><a href="/chapter/{{{ $chapter->_id }}}">{{{ $chapter->chapter_name }}}{{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}}</a></td>
                    <td>{{{ $chapter->chapter_type }}}</td>
                    <td><a href="/chapter/{{{ $chapter->_id }}}/edit">Edit</a> <button data-mongoid="{{$chapter->_id}}">Delete</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="/chapter/create">Create New Chapter</a>
@stop

