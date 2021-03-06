@extends('layout')

@section('pageTitle')
    Chapter Reports
@stop

@section('content')
    <h1 class="text-center">Chapter Reports for {{ $chapterName }}</h1>

    <div class="row">
        <div class=" col-sm-2 underline">Status</div>
        <div class=" col-sm-2 underline">Report Date</div>
        <div class=" col-sm-2 ">&nbsp;</div>
    </div>
    <br>
    @if(empty($reports))
        <div class="row">
            <div class=" col-sm-6 text-center ">
                No chapter reports found
            </div>
        </div>
    @else
        @foreach($reports as $report)
            <div class="row zebra-even">
                <div class="col-sm-2">
                    @if(empty($report['report_sent']) === true)
                        Pending
                    @else
                        Sent
                    @endif
                </div>
                <div class="col-sm-2">
                    {!!date('F, Y', strtotime($report['report_date']))!!}
                </div>
                <div class="col-sm-1 nowrap">
                    <a class="fa fa-eye my" href="{!! route('report.show', [ $report->id ]) !!}" data-toggle="tooltip"
                       title="View Report"></a>&nbsp;
                    @if(empty($report['report_sent']) === true)
                        <a class="fa fa-edit my" href="{!! route('report.edit', [ $report->id ]) !!}"
                           data-toggle="tooltip" title="Edit Report"></a>

                        <a class="fa fa-envelope my" href="{!! route('report.send', [$report->id]) !!}"
                           data-toggle="tooltip" title="Send Report"
                           data-report-date="{!!date('F, Y', strtotime($report['report_date']))!!}"></a>&nbsp;
                    @endif
                </div>
                @if(!empty(Session::get('orig_user')))
                    <div class="col-sm-1 nowrap">
                        {{ Form::open(['route' => ['report.destroy', $report->id], 'method' => 'delete']) }}
                        <button class="btn btn-danger btn-sm Incised901Light" title="Delete Report"
                                data-toggle="tooltip">Delete Report
                        </button>
                        {{ Form::close() }}
                    </div>
                @endif

            </div>
        @endforeach
    @endif
    <br><br>
    <div class="row">
        <div class=" col-sm-6 " text-center
        ">
        <a href="{!! route('report.create')!!}" class="btn btn-success">Create New</a>
    </div>
    </div>


@stop

@section('scriptFooter')
    <script>
        $('.fa-envelope').on('click', function (event) {
            if (!confirm('Click Ok to send the ' + $(this).data('report-date') + ' Chapter Report')) {
                event.preventDefault();
            }
        });
    </script>
@stop