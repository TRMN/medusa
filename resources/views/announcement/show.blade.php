@extends('layout')

@section('pageTitle')
{!! $announcement->summary !!}
@stop

@section('content')
<h1>{!! $announcement->summary !!}</h1>
<div class="meta"><a href="{!! route( 'announcement.index') !!}" data-toggle="tooltip" title="Back to Announcement List">Back to Announcement List</a></div>
<div class="meta">
    @if( $announcement->user )
    <div class="author">
        Written By <span>{!! $announcement->user->getGreeting() !!} {!! $announcement->user->last_name !!}</span>
    </div>
    @endif
    @if($announcement->is_published)
    <span class="publish-date">Published on {!! $announcement->publish_date !!}</span>
    @endif
    <span class="modified-date">Last modified on {!! $announcement->updated_at !!}</span>
</div>
<article>
    {!! $announcement->body !!}
</article>
@if( Auth::id() == $announcement->user->id)
    <a class="btn" href="{!! route( 'announcement.edit' , $announcement->id ) !!}">Edit</a>
@endif
@stop
