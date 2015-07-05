@extends('layout')
<?php
$chapterType = Chapter::getChapterType($detail->_id);

if (( $chapterType == "ship" || $chapterType == "station" ) && isset( $detail->hull_number ) === true) {
    $hull_number = ' (' . $detail->hull_number . ')';
} else {
    $hull_number = '';
}
?>
@section('pageTitle')
    {{{ $detail->chapter_name }}} {{{$hull_number}}}
@stop

@section('content')
    <h2 class="Incised901Bold padding-5">{{{ $detail->chapter_name }}} {{{$hull_number}}}</h2>
    <h3 class="Incised901Bold padding-5">{{{ isset($detail->ship_class) ? $detail->ship_class . ' Class' : '' }}}</h3>

    <div class="row padding-5">
        <div class="small-2 columns Incised901Light">
            Chapter Name:
        </div>
        <div class="small-10 columns Incised901Light">
            {{{ $detail->chapter_name }}} {{{$hull_number}}}
        </div>
    </div>
    <div class="row padding-5">
        <div class="small-2 columns Incised901Light">
            Chapter Type:
        </div>
        <div class="small-10 columns Incised901Light">
            {{{ucfirst($detail->chapter_type)}}}
        </div>
    </div>
    @if($higher)
        <?php
        $higherType = Chapter::getChapterType($higher->_id);

        if (( $higherType == "ship" || $higherType == "station" ) && isset( $higher->hull_number ) === true) {
            $higherHullNumber = ' (' . $higher->hull_number . ')';
        } else {
            $higherHullNumber = '';
        }
        ?>
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light">
                Component of:
            </div>
            <div class="small-10 columns Incised901Light">
                <a href="{{{route('chapter.show', $higher->_id)}}}">{{{$higher->chapter_name}}} {{{$higherHullNumber}}}</a>
            </div>
        </div>
    @endif
    @if (count($includes) > 0)
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light">
                Elements:
            </div>
            <div class="small-10 columns Incised901Light">
                @foreach($includes as $chapter)
                    <?php
                    $elementType = Chapter::getChapterType($chapter->_id);

                    if (( $elementType == "ship" || $elementType == "station" ) && isset( $chapter->hull_number ) === true) {
                        $elementHullNumber = ' (' . $chapter->hull_number . ')';
                    } else {
                        $elementHullNumber = '';
                    }
                    ?>
                    <a href="/chapter/{{{ $chapter->_id }}}">{{{ $chapter->chapter_name }}}{{{$elementHullNumber}}}</a>
                    &nbsp;<br/>
                @endforeach
            </div>
        </div>
    @endif
    @if (count($command) > 0)
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light">
                Command Crew:
            </div>
            <div class="small-10 columns Incised901Light">
                <div style="padding-bottom: 2px">
                    Commanding Officer:
                    @if( isset( $command['CO'][0] ) )
                        <a href="{{ route('user.show' , [(string)$command['CO'][0]->_id]) }}">{{{ $command['CO'][0]->getGreeting() }}} {{{ $command['CO'][0]->first_name }}}{{{ isset($command['CO'][0]->middle_name) ? ' ' . $command['CO'][0]->middle_name : '' }}} {{{ $command['CO'][0]->last_name }}}{{{ !empty($command['CO'][0]->suffix) ? ' ' . $command['CO'][0]->suffix : '' }}}, {{{$command['CO'][0]->branch}}}</a>
                    @else
                        N/A
                    @endif
                </div>
                <div style="padding-bottom: 2px;">
                    Executive Officer:
                    @if( isset( $command['XO'][0] ) )
                        <a href="{{ route('user.show' , [(string)$command['XO'][0]->id]) }}">{{{ $command['XO'][0]->getGreeting() }}} {{{ $command['XO'][0]->first_name }}}{{{ isset($command['XO'][0]->middle_name) ? ' ' . $command['XO'][0]->middle_name : '' }}} {{{ $command['XO'][0]->last_name }}}{{{ !empty($command['XO'][0]->suffix) ? ' ' . $command['XO'][0]->suffix : '' }}}, {{{$command['XO'][0]->branch}}}</a>
                    @else
                        N/A
                    @endif
                </div>
                <div style="padding-bottom: 2px;">
                    Bosun:
                    @if( isset( $command['BOSUN'][0] ) )
                        <a href="{{ route('user.show' , [(string)$command['BOSUN'][0]->id]) }}">{{{ $command['BOSUN'][0]->getGreeting() }}} {{{ $command['BOSUN'][0]->first_name }}}{{{ isset($command['BOSUN'][0]->middle_name) ? ' ' . $command['BOSUN'][0]->middle_name : '' }}} {{{ $command['BOSUN'][0]->last_name }}}{{{ !empty($command['BOSUN'][0]->suffix) ? ' ' . $command['BOSUN'][0]->suffix : '' }}}, {{{$command['BOSUN'][0]->branch}}}</a>
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if (count($crew) > 0)
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light">
                Crew Roster:
            </div>
            <div class="small-10 columns Incised901Light">
                @foreach($crew as $member)
                    <div style="padding-bottom: 2px;">
                        <a href="{{ route('user.show', [$member->_id]) }}">{{{ $member->getGreeting() }}} {{{ $member->first_name }}}{{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}} {{{ $member->last_name }}}{{{ !empty($member->suffix) ? ' ' . $member->suffix : '' }}}, {{{$member->branch}}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@stop
