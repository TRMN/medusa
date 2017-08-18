@extends('layout')

@section('pageTitle')
    Commission {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
@stop

@section('content')
    <h1>
        Editing {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}</h1>

    {!! Form::model( $chapter, [ 'route' => [ 'chapter.update', $chapter->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('chapter_name', 'Chapter Name') !!} {!! Form::text('chapter_name') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('Chapter Type', 'Chapter Type') !!} {!! Form::select('chapter_type', $chapterTypes, $chapter->chapter_type, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('hull_number', 'Hull Number') !!} {!! Form::text('hull_number') !!}
            {!! Form::label('ship_class', 'Ship Class') !!} {!! Form::text('ship_class') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('Assigned To', 'Assigned To') !!} {!! Form::select('assigned_to', $chapterList, $chapter->assigned_to, ['id' => 'assigned_to']) !!}
        </div>
    </div>

    <h5><em>Note:</em> To recommission a ship, set the commission date to newer than the decommission date. When the
        form is submitted, the decommission date will be removed from the record</h5>

    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('commission_date', 'Commission Date (if appropriate') !!}  {!!Form::date('commission_date')!!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6  ninety Incised901Light ">
            {!! Form::label('decommission_date', 'Decommission Date (if appropriate)') !!}
            @if($numCrew > 0)
                <p>Unable to set the decommission date as there are still crew assigned to the ship</p>

            @else
                {!!Form::date('decommission_date')!!}
            @endif

        </div>
    </div>


    <a class="btn" href="{!! URL::previous() !!}">Cancel</a> {!! Form::submit( 'Save', [ 'class' => 'btn' ] ) !!}
    {!! Form::close() !!}
@stop
@section('scriptFooter')
    <script type="application/javascript">
        $('#assigned_to').selectize({
            closeAfterSelect: true
        });
    </script>
@stop