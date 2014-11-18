@extends('layout')

@section('pageTitle')
Announcements
@stop

@section('content')
<h1>Announcements</h1>

<table>
    <thead>
        <tr><th>Summary</th><th>Author</th><th>Modified On<th>Status</th><th></th></tr>
    </thead>
    <tbody>

@foreach($announcements as $announcement)
    @if( $announcement->user && $author = $announcement->user->getGreeting() )
    @elseif( $author = '' && true )
    @endif
    <tr>
        <td><a href="{{ route('announcement.edit', [ $announcement->id ] )}}">{{{ $announcement->summary }}}</a></td>
        <td>{{{ $author ? $author[ 'rank' ] . ' ' . $author[ 'last_name' ] : '' }}}</td>
        <td>{{{ $announcement->updated_at }}}</td>
        <td>{{{ $announcement->is_published ? 'Published' : 'Unpublished' }}}</td>
        <td><button class="btn">Delete</button></td>
    </tr>
@endforeach

    </tbody>
</table>

<a href="{{ route('announcement.create')}}" class="button">Create New</a>

@stop