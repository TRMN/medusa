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
                    <td>
                    @if($lookupRMN)
                            <span class="green fa
                                @if($member['status'] == 'email') {{'fa-envelope'}}
                                    @elseif($member['status'] == 'name') {{'fa-address-card'}}
                                    @else {{'fa-question-circle'}}
                            @endif "></span>&nbsp;
                    @endif
                    {!! $member['name'] !!}</td>
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

        <div class="row padding-bottom-10">
            <div class="col-sm-6 text-right">
                <a href="/upload/admin" class="btn btn-danger"><span class="fa fa-times"></span> Cancel</a>
            </div>
            <div class="col-sm-6 text-left">
                {{Form::open(['url' => '/upload/processpoints'])}}
                {{Form::hidden('logId', $log['_id'])}}
                {{Form::hidden('csv', $csv)}}
                {{Form::hidden('filename', $filename)}}
                @if($lookupRMN)
                    {{Form::hidden('lookupRMN', $lookupRMN)}}
                @endif
                <button type="submit" class="btn btn-success"><span class="fa fa-upload"></span> Import</button>
            </div>
        </div>

        @if($lookupRMN)
            <div class="row padding-top-10 text-center">
                <div class="col-sm-3">
                    <span class="fa fa-envelope green"></span>
                    Found by email address
                </div>
                <div class="col-sm-3">
                    <span class="fa fa-address-card green"></span>
                    Found by name
                </div>
                <div class="col-sm-3">
                    <span class="fa fa-question-circle green"></span>
                    Not found, will be added
                </div>
            </div>
        @endif
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