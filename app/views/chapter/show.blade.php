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
                @if (count($command))
                <tr>
                    <td>Command Crew:</td>
                    <td>
                        @if ($command['CO'])
                            Commanding Officer: <a href="{{ route('user.show' , [$command['CO']->_id]) }}">{{{ $command['CO']->greeting }}} {{{ $command['CO']->first_name }}}{{{ isset($command['CO']->middle_name) ? ' ' . $command['CO']->middle_name : '' }}} {{{ $command['CO']->last_name }}}{{{ isset($command['CO']->suffix) ? ' ' . $command['CO']->suffix : '' }}}</a><br />
                            Executive Officer: <a href="{{ route('user.show' , [$command['XO']->_id]) }}">{{{ $command['XO']->greeting }}} {{{ $command['XO']->first_name }}}{{{ isset($command['XO']->middle_name) ? ' ' . $command['XO']->middle_name : '' }}} {{{ $command['XO']->last_name }}}{{{ isset($command['XO']->suffix) ? ' ' . $command['XO']->suffix : '' }}}</a><br />
                            Bosun: <a href="{{ route('user.show' , [$command['Bosun']->_id]) }}">{{{ $command['Bosun']->greeting }}} {{{ $command['Bosun']->first_name }}}{{{ isset($command['Bosun']->middle_name) ? ' ' . $command['Bosun']->middle_name : '' }}} {{{ $command['Bosun']->last_name }}}{{{ isset($command['Bosun']->suffix) ? ' ' . $command['Bosun']->suffix : '' }}}</a>
                        @endif
                    </td>
                </tr>
                @endif
                @if (count($crew))
                <tr>
                    <td>Crew Roster:</td>
                    <td>
                        @foreach($crew as $member)
                        <a href="{{ route('user.show', [$member->_id]) }}">{{{ $member->greeting }}} {{{ $member->first_name }}}{{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}} {{{ $member->last_name }}}{{{ isset($member->suffix) ? ' ' . $member->suffix : '' }}}</a><br />
                        @endforeach
                    </td>
                </tr>
                @endif
        </tbody>
    </table>
    <a href="/chapter">Chapter Listing</a>
@stop
