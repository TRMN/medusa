@extends('layout')

@section('pageTitle')
Create a New Chapter
@stop

@section('content')
<h2>Create a New Chapter</h2>
{{ Form::open(array('route' => 'ChapterController@save')) }}
<div class="form-group">
    {{ Form::label('chapter_name', 'Chapter Name') }} {{ Form::text('chapter_name') }}
</div>
<div class="form-group">
    {{ Form::label('Chapter Type', 'Chapter Type') }} {{ Form::select('chapter_type', $chapterTypes) }}
</div>
<div class="form-group">
    {{ Form::label('hull_number', 'Hull Number (if appropriate)') }} {{ Form::text('hull_number') }}
</div>
{{ Form::submit('Save') }}
{{ Form::close() }}
@stop
