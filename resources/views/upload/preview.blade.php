@extends('layout')

@section('pageTitle')
    Import preview for {{ $log['chapter_name'] }}
@stop

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Import preview for {{ $log['chapter_name'] }}</h1>

        <table id="preview">
            <thead>
            <tr>
                <th>Name</th>
                <th>Chapter Name</th>
            </tr>
            </thead>
            @foreach($preview as $member)
                <tr class="zebra-even">
                    <td>{!! $member['name'] !!}</td>
                    <td>{{$member['chapter']}}</td>
                </tr>
            @endforeach
            <tfoot>
            <tr>
                <th>Name</th>
                <th>Chapter Name</th>
            </tr>
            </tfoot>
        </table>

        <div class="row">
            <div class="col-sm-6 text-right">
                <a href="/upload/admin" class="btn btn-danger"><span class="fa fa-times"></span> Cancel</a>
            </div>
            <div class="col-sm-6 text-left">
                {{Form::open(['url' => '/upload/processpoints'])}}
                {{Form::hidden('logId', $log['_id'])}}
                {{Form::hidden('csv', $csv)}}
                {{Form::hidden('filename', $filename)}}
                <button type="submit" class="btn btn-success"><span class="fa fa-upload"></span> Import</button>
            </div>
        </div>
    </div>
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(function () {
            $('#preview').DataTable({
                "autoWidth": true,
                "pageLength": 10,
                "columnDefs": [{type: 'natural-nohtml', targets: '_all'}],
                "language": {
                    "emptyTable": "No records found"
                },
                "$UI": true
            });
        });
    </script>
@stop