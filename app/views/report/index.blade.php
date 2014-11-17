@extends('layout')

@section('pageTitle')
Announcements
@stop

@section('content')
<h1>Reports</h1>

<table>
    <thead>
        <tr><th>Summary</th><th>Author</th><th>Modified On<th>Status</th><th></th></tr>
    </thead>
    <tbody>

@foreach($reports as $report)
    <tr><td><a href="{{ route('report.edit', [ $report->id ] )}}">{{{ $report->summary }}}</a></td><td>{{{ $report->author ? $report->user->getGreeting() : '' }}}</td><td>{{{ $report->updated_at }}}</td><td>{{{ $report->is_published ? 'Published' : 'Unpublished' }}}</td><td><button class="btn">Delete</button></td></tr>
@endforeach

    </tbody>
</table>

<a href="{{ route('report.create')}}" class="button">Create New</a>

@stop
