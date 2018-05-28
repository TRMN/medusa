@extends('layout')

@section('pageTitle')
    Editing {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
@stop

@section('content')
    <h1>
        Editing {!! $chapter->chapter_name !!}{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}</h1>

    {!! Form::model( $chapter, [ 'route' => [ 'chapter.update', $chapter->_id ], 'method' => 'put' ] ) !!}
    <div class="row">
        <div class="col-sm-6  Incised901Light form-group">
            {!! Form::label('chapter_name', 'Chapter Name') !!} {!! Form::text('chapter_name', $chapter->chapter_name, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('Chapter Type', 'Chapter Type') !!} {!! Form::select('chapter_type', $chapterTypes, $chapter->chapter_type, ['class' => 'selectize']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('hull_number', 'Hull Number') !!} {!! Form::text('hull_number', $chapter->hull_number, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('ship_class', 'Ship Class') !!} {!! Form::text('ship_class', $chapter->ship_class, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('Assigned To', 'Assigned To') !!} {!! Form::select('assigned_to', $chapterList, $chapter->assigned_to, ['id' => 'assigned_to']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            <h4><em>Note:</em> To recommission a ship, set the commission date to newer than the decommission date. When
                the
                form is submitted, the decommission date will be removed from the record</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('commission_date', 'Commission Date (if appropriate') !!}  {!!Form::date('commission_date', $chapter->commission_date, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light form-group">
            {!! Form::label('decommission_date', 'Decommission Date (if appropriate)') !!}
            @if($numCrew > 0)
                <p>Unable to set the decommission date as there are still crew assigned to the ship</p>

            @else
                {!!Form::date('decommission_date', $chapter->decommission_date, ['class' => 'form-control'])!!}
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 Incised901Light text-center">
            <a class="btn btn-warning" href="{!! URL::previous() !!}"><span class="fa fa-times"></span> Cancel </a>
            <button type="submit" class="btn btn-success"><span class="fa fa-save"><span
                            class="Incised901Light"> Save </span></span></button>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('scriptFooter')
    <script type="application/javascript">
        $('#assigned_to').selectize({
            closeAfterSelect: true
        });
    </script>
@stop