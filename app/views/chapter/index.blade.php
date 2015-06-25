@extends('layout')

@section('pageTitle')
Chapters
@stop

@section('content')
    <h1>Chapter List</h1>
    <table id="chapterList" class="compact row-border stripe" width="75%">
        <thead>
            <tr>
                <th>Chapter Name</th>
                <th>Chapter Type</th>
                <th width="12%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $chapters as $chapter )
                <tr>
                    <td><a href="/chapter/{{{ $chapter->_id }}}">{{{ $chapter->chapter_name }}}
                            <?php
                            $chapterType = Chapter::getChapterType($chapter->_id);
                            ?>
                            @if($chapterType == "ship" || $chapterType == "station")
                                {{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}}
                            @endif
                        </a></td>
                    <td>{{{ $chapter->chapter_type }}}</td>
                    <td width="12%"><a href="/chapter/{{{ $chapter->_id }}}/edit" class="tiny">Edit</a> <a href="#" data-mongoid="{{$chapter->_id}}" class="tiny delete-chapter">Delete</a></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Chapter Name</th>
            <th>Chapter Type</th>
            <th width="12%">Actions</th>
        </tr>
        </tfoot>
    </table>
    <a href="{{ route('chapter.create') }}" class="button">Create New Chapter</a>
@stop
