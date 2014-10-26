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
                @if (count($command) > 0)
                <tr>
                    <td>Command Crew:</td>
                    <td>
                        @if ( isset( $command['CO'][0] ) )
                            <ul>
                                <li>Commanding Officer: <a href="{{ route('user.show' , [(string)$command['CO'][0]->_id]) }}">{{{ $command['CO'][0]->getGreeting() }}} {{{ $command['CO'][0]->first_name }}}{{{ isset($command['CO'][0]->middle_name) ? ' ' . $command['CO'][0]->middle_name : '' }}} {{{ $command['CO'][0]->last_name }}}{{{ isset($command['CO'][0]->suffix) ? ' ' . $command['CO'][0]->suffix : '' }}}</a></li>
                                <li>Executive Officer: <a href="{{ route('user.show' , [(string)$command['XO'][0]->id]) }}">{{{ $command['XO'][0]->getGreeting() }}} {{{ $command['XO'][0]->first_name }}}{{{ isset($command['XO'][0]->middle_name) ? ' ' . $command['XO'][0]->middle_name : '' }}} {{{ $command['XO'][0]->last_name }}}{{{ isset($command['XO'][0]->suffix) ? ' ' . $command['XO'][0]->suffix : '' }}}</a></li>
                                <li>Bosun: <a href="{{ route('user.show' , [(string)$command['Bosun'][0]->id]) }}">{{{ $command['Bosun'][0]->getGreeting() }}} {{{ $command['Bosun'][0]->first_name }}}{{{ isset($command['Bosun'][0]->middle_name) ? ' ' . $command['Bosun'][0]->middle_name : '' }}} {{{ $command['Bosun'][0]->last_name }}}{{{ isset($command['Bosun'][0]->suffix) ? ' ' . $command['Bosun'][0]->suffix : '' }}}</a></li>
                            </ul>
                        @endif
                    </td>
                </tr>
                @endif
                @if (count($crew) > 0)
                <tr>
                    <td>Crew Roster:</td>
                    <td>
                        @foreach($crew as $member)
                        <a href="{{ route('user.show', [$member->_id]) }}">{{{ $member->getGreeting() }}} {{{ $member->first_name }}}{{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}} {{{ $member->last_name }}}{{{ isset($member->suffix) ? ' ' . $member->suffix : '' }}}</a><br />
                        @endforeach
                    </td>
                </tr>
                @endif
        </tbody>
    </table>
    <a href="/chapter">Chapter Listing</a>
@stop
