@extends('layout')

@section('pageTitle')
Editing {{{ $chapter->chapter_name }}}{{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}}
@stop

@section('content')
<h1>Editing {{{ $chapter->chapter_name }}}{{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}}</h1>
<?php
if (count($errors->all())) {
echo "<p>Please correct the following errors:</p>\n<ul>\n";
    foreach ($errors->all() as $message)
    {
        echo "<li>" . $message . "</li>\n";
    }
}
echo "</ul>\n";
?>
{{ Form::model( $chapter, [ 'route' => [ 'chapter.update', $chapter->_id ], 'method' => 'put' ] ) }}
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
{{ Form::submit( 'Save', [ 'class' => 'button' ] ) }}
{{ Form::close() }}
@stop
