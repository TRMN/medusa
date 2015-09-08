@extends('layout')

@section('pageTitle')
Assignment Change Requests
@stop

@section('bodyclasses')
@stop

@section('content')
<table id="changeRequests">
    <thead>
        <tr>
            <th>Requested For</th>
            <th>Requested By</th>
            <th>Request Type</th>
            <th>From</th>
            <th>To</th>
            <th>Action</th>
        </tr>
    </thead>
    @foreach( $records as $record )
        <tr>
            <td>{{ $record->user->getGreeting() }} {{ $record->user->first_name }}{{ isset($record->user->middle_name) ? ' ' . $record->user->middle_name : '' }} {{ $record->user->last_name }}{{ !empty($record->user->suffix) ? ' ' . $record->user->suffix : '' }}</td>
            <td>{{ $record->requestor->getGreeting() }} {{ $record->requestor->first_name }}{{ isset($record->requestor->middle_name) ? ' ' . $record->requestor->middle_name : '' }} {{ $record->requestor->last_name }}{{ !empty($record->requestor->suffix) ? ' ' . $record->requestor->suffix : '' }}</td>
            <td>@if($record->req_type == 'branch')Branch Change
                @elseif($record->req_type == 'assignment.chapter')Chapter Change
                @elseif($record->req_type == 'assignment.billet')Billet Change @endif
            </td>
            <td>@if($record->req_type == 'assignment.chapter'){{$record->old_chapter}} @else {{$record->old_value}} @endif</td>
            <td>@if($record->req_type == 'assignment.chapter'){{$record->new_chapter}} @else {{$record->new_value}} @endif</td>
            <td><i class="fi-check green size-36" />&nbsp;<i class="fi-x red size-36" /></td>
        </tr>
    @endforeach
    <tfoot>
    <tr>
        <th>Requested For</th>
        <th>Requested By</th>
        <th>Request Type</th>
        <th>From</th>
        <th>To</th>
        <th>Action</th>
    </tr>
    </tfoot>
</table>
@stop
