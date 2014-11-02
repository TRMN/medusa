@extends('layout')

@section('pageTitle')
{{{ $announcement->summary }}}
@stop

@section('content')
<h1>{{{ $announcement->summary }}}</h1>
<div class="meta">
    @if($announcementUser)
    <div class="author">
        Written By <span>{{{ $announcementUser[ 'rank' ] }}} {{ $announcementUser['last_name'] }}</span>
    </div>
    @endif
    @if($announcement->is_published)
    <span class="publish-date">Published on {{{ $announcement->publish_date }}}</span>
    @endif
    <span class="modified-date">Last modified on {{{ $announcement->updated_at }}}</span>
</div>
<article>
    {{ $announcement->body }}
</article>
@stop
