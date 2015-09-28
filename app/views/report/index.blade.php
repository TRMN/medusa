@extends('layout')

@section('pageTitle')
Chapter Reports
@stop

@section('content')
<h1 class="text-center">Chapter Reports</h1>

<div class="row">
    <div class="columns small-2 underline">Status</div>
    <div class="columns small-2 underline">Report Date</div>
    <div class="columns small-2 end">&nbsp;</div>
</div>
<br>
@if(count($reports) === 0)
    <div class="row">
        <div class="columns small-6 text-center end">
            No chapter reports found
        </div>
    </div>
@else
    @foreach($reports as $report)
        <div class="row">
            <div class="columns small-2">
                @if(empty($report['report_sent']) === true)
                    Pending
                @else
                    Sent
                @endif
            </div>
            <div class="columns small-2">
                {{date('F, Y', strtotime($report['report_date']))}}
            </div>
            <div class="columns small-2 end">
                <a class="fi-eye my size-24" href="{{ route('report.show', [ $report->id ]) }}" title="View Report"></a>
                @if(empty($report['report_sent']) === true)
                    <a class="fi-mail my size-24" href="{{ route('report.send', [$report->id]) }}" title="Send Report"></a>
                    <a class="fi-page-edit green size-24" href="{{ route('report.edit', [ $report->id ]) }}" title="Edit Report"></a>
                @endif
            </div>
        </div>
        <br>
    @endforeach
@endif
<br><br>
<div class="row">
    <div class="columns small-6 end text-center">
        <a href="{{ route('report.create')}}" class="button round">Create New</a>
    </div>
</div>


@stop
