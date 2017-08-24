@extends('layout')

@section('pageTitle')
Chapter Reports
@stop

@section('content')
<h1 class="text-center">Chapter Reports</h1>

<div class="row">
    <div class=" col-sm-2 underline">Status</div>
    <div class=" col-sm-2 underline">Report Date</div>
    <div class=" col-sm-2 ">&nbsp;</div>
</div>
<br>
@if(count($reports) === 0)
    <div class="row">
        <div class=" col-sm-6 text-center ">
            No chapter reports found
        </div>
    </div>
@else
    @foreach($reports as $report)
        <div class="row">
            <div class=" col-sm-2">
                @if(empty($report['report_sent']) === true)
                    Pending
                @else
                    Sent
                @endif
            </div>
            <div class=" col-sm-2">
                {!!date('F, Y', strtotime($report['report_date']))!!}
            </div>
            <div class=" col-sm-2 ">
                <a class="fa fa-eye my size-24" href="{!! route('report.show', [ $report->id ]) !!}" data-toggle="tooltip" title="View Report"></a>&nbsp;
                @if(empty($report['report_sent']) === true)
                    <a class="fa fa-envelope my size-24" href="{!! route('report.send', [$report->id]) !!}" data-toggle="tooltip" title="Send Report"></a>&nbsp;
                    <a class="fa fa-file-o-edit green size-24" href="{!! route('report.edit', [ $report->id ]) !!}" data-toggle="tooltip" title="Edit Report"></a>
                @endif
            </div>
        </div>
        <br>
    @endforeach
@endif
<br><br>
<div class="row">
    <div class=" col-sm-6 " text-center">
        <a href="{!! route('report.create')!!}" class="btn round">Create New</a>
    </div>
</div>


@stop
