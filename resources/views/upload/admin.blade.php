@extends('layout')

@section('pageTitle')
    Promotion Points Administration
@stop

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Promotion Point Administration</h1>

        @if(is_null($logs))
            <div class="row">
                <div class="col-sm-12 text-center Incised901Light">
                    No spreadsheets have been uploaded yet
                </div>
            </div>
        @else
            <table class="trmnTableWithActions zebra">
                <thead>
                <tr>
                    <th>Chapter</th>
                    <th>Filename</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                @foreach($logs as $log)
                    @foreach($log['files'] as $file)
                        <tr>
                            <td>{{$log['chapter_name']}}</td>
                            <td>{{$file['filename']}}</td>
                            <td>{{$file['current_status']}}</td>
                            <td>{{date("F j, Y @ g:i a", $file['status_ts'])}}</td>
                            <td class="nowrap">
                                <a href="/download/sheet/{{$log['chapter_id']}}/{{$file['filename']}}"
                                   class="btn btn-xs btn-danger" title="Download {{$file['filename']}}"><span
                                            class="fa fa-download"></span></a>
                                <a href="/upload/points/{{$log['_id']}}/{{$file['filename']}}"
                                   class="btn btn-xs btn-success" title="Upload CSV for processing">
                                    <span class="fa fa-upload"></span></a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                <tfoot>
                <tr>
                    <th>Chapter</th>
                    <th>Filename</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
            </table>
        @endif
    </div>
@stop

@section('scriptFooter')

@stop