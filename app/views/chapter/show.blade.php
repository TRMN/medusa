@extends('layout')

@section('pageTitle')
{{{ $detail->chapter_name }}}{{{ isset($detail->hull_number) ? ' (' . $detail->hull_number . ')' : '' }}}
@stop

@section('content')
<h2>{{{ $detail->chapter_name }}}{{{ isset($detail->hull_number) ? ' (' . $detail->hull_number . ')' : '' }}}</h2>
<h3>{{{ isset($detail->ship_class) ? $detail->ship_class . ' Class' : '' }}}</h3>
    <table class="table table-striped">
        <tbody>
                <tr>
                    <td>Chapter Name</td>
                    <td>{{{ $detail->chapter_name }}}{{{ isset($detail->hull_number) ? ' (' . $detail->hull_number . ')' : '' }}} <a href="/chapter/{{{ $detail->_id }}}/edit">Edit</a></td>
                </tr>
                <tr>
                    <td>Chapter Type</td>
                    <td>{{{ $detail->chapter_type }}}</td>
                </tr>
                @if ($higher)
                <tr>
                    <td>Assigned To:</td>
                    <td><a href="/chapter/{{{ $higher->_id }}}">{{{ $higher->chapter_name }}}{{{ isset($higher->hull_number) ? ' (' . $higher->hull_number . ')' : '' }}}</a></td>
                </tr>
                @endif
                @if (count($includes) > 0)
                <tr>
                    <td>Includes:</td>
                    <td>
                    @foreach($includes as $chapter)
                        <a href="/chapter/{{{ $chapter->_id }}}">{{{ $chapter->chapter_name }}}{{{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}}</a>&nbsp;
                    @endforeach
                    </td>
                </tr>
                @endif
        </tbody>
    </table>
    <a href="/chapter">Chapter Listing</a>
@stop
