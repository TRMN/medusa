@extends('layout')

@section('pageTitle')
{{{ $announcement->summary }}}
@stop

@section('content')
<h1>{{{ $announcement->summary }}}</h1>
<div class="meta">
    @if($announcement->author)
    <div class="author">
        Written By <span>{{{ $announcement->author->getGreeting() }}}</span>
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
