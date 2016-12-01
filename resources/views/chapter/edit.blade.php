@extends('layout')

@section('pageTitle')
    Commission {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
@stop

@section('content')
    <h1>
        Editing {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}</h1>

    {!! Form::model( $chapter, [ 'route' => [ 'chapter.update', $chapter->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('chapter_name', 'Chapter Name') !!} {!! Form::text('chapter_name') !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('Chapter Type', 'Chapter Type') !!} {!! Form::select('chapter_type', $chapterTypes, $chapter->chapter_type) !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('hull_number', 'Hull Number') !!} {!! Form::text('hull_number') !!}
            {!! Form::label('ship_class', 'Ship Class') !!} {!! Form::text('ship_class') !!}
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('Assigned To', 'Assigned To') !!} {!! Form::select('assigned_to', $chapterList, $chapter->assigned_to, ['id' => 'assigned_to']) !!}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('commission_date', 'Commission Date (if appropriate') !!}  {!!Form::date('commission_date')!!}
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns ninety Incised901Light end">
            {!! Form::label('decommission_date', 'Decommission Date (if appropriate)') !!}
            @if($numCrew > 0)
                <p>Unable to set the decommission date as there are still crew assigned to the ship</p>

            @else
                {!!Form::date('decommission_date')!!}
            @endif

        </div>
    </div>

    <a class="button" href="{!! URL::previous() !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'button' ] ) !!}
    {!! Form::close() !!}
@stop
@section('scriptFooter')
    <script type="application/javascript">
        $('#assigned_to').selectize({
            closeAfterSelect: true
        });
    </script>
@stop