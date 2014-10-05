@extends('layout')

@section('pageTitle')
Create a New Chapter
@stop

@section('content')
<h2>Create a New Chapter</h2>
{{ Form::model( $chapter, [ 'route' => [ 'chapter.store' ] ] ) }}
<div class="form-group">
    {{ Form::label('chapter_name', 'Chapter Name') }} {{ Form::text('chapter_name') }}
</div>
<div class="form-group">
    {{ Form::label('Chapter Type', 'Chapter Type') }} {{ Form::select('chapter_type', $chapterTypes) }}
</div>
<div class="form-group">
    {{ Form::label('hull_number', 'Hull Number (if appropriate)') }} {{ Form::text('hull_number') }}
    {{ Form::label('ship_class', 'Ship Class') }} {{ Form::text('ship_class') }}
</div>
<div class="form-group">
    {{ Form::label('Assigned To', 'Assigned To') }} {{ Form::select('assigned_to', $chapterList) }}
</div>
{{ Form::submit( 'Save', [ 'class' => 'button'] ) }}
{{ Form::close() }}
@stop
