@extends('layout')

@section('pageTitle')
Create a New Ship/Unit
@stop

@section('content')
<h2>Create a New Ship/Unit</h2>
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
{{ Form::model( $chapter, [ 'route' => [ 'chapter.store' ] ] ) }}
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('chapter_name', 'Chapter Name') }} {{ Form::text('chapter_name') }}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('Chapter Type', 'Chapter Type') }} {{ Form::select('chapter_type', $chapterTypes) }}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('hull_number', 'Hull Number/Chapter Identifier (if appropriate)') }} {{ Form::text('hull_number') }}
        </div>
    </div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('ship_class', 'Ship Class (if appropriate') }} {{ Form::text('ship_class') }}
        </div>
</div>
<div class="row">
    <div class="small-6 columns ninety Incised901Light end">
    {{ Form::label('Assigned To', 'Parent Chapter/Unit') }} {{ Form::select('assigned_to', $chapterList) }}
        </div>
</div>
{{ Form::submit( 'Save', [ 'class' => 'button round'] ) }}
{{ Form::close() }}
@stop
