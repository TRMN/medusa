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
    <tr>
        <td><a href="{{ route('announcement.edit', [ $announcement->id ] )}}">{{{ $announcement->summary }}}</a></td>
        <td>@if( $announcement->user ){{{ $announcement->user->getGreeting() . ' ' . $announcement->user->last_name }}} @else Undefined @endif</td>
        <td>{{{ $announcement->updated_at }}}</td>
        <td>{{{ $announcement->is_published ? 'Published' : 'Unpublished' }}}</td>
        <td><button id="{{{ $announcement->id }}}" class="btn" onclick="confirmDelete( '{{ $announcement->id }}' );" data-title="{{{ $announcement->summary }}}">Delete</button>
            {{ Form::open([ 'url' => route( 'announcement.destroy' , [ $announcement->id ] ) , 'method'=> 'delete' , 'id' => 'deleteAnnouncement-' . $announcement->id , 'style' => 'display:none;' ]) }}
                {{ Form::submit( 'Delete' )  }}
            {{ Form::close() }}
        </td>
    </tr>
@endforeach

    </tbody>
</table>

<a href="{{ route('announcement.create') }}" class="button">Create New</a>

@stop

@section( 'scriptFooter' )
<script>
    var confirmDelete = function( id ) {
        var title = jQuery( '#' + id ).data( 'title' );
        var message = confirm( 'Are you sure you want to delete the ' + title +' announcement?' );
        if( message == true ) {
          return document.getElementById( 'deleteAnnouncement-' + id ).submit();
        } else {
          return false;
        }
      }
</script>
@stop
