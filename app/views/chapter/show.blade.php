@extends('layout')
<?php
$chapterType = Chapter::getChapterType($detail->_id);

if (( in_array($chapterType, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) && isset( $detail->hull_number ) === true) {
    $hull_number = ' (' . $detail->hull_number . ')';
} else {
    $hull_number = '';
}
?>
@section('pageTitle')
    {{ $detail->chapter_name }} {{$hull_number}}
@stop

@section('content')
    <div class="row">
        @if(file_exists(public_path() . '/crests/' . $detail->hull_number . '.svg') === true)
            <div class="columns small-2">
                <img class='crest' src="{{asset('/crests/' . $detail->hull_number . '.svg')}}" alt="{{$detail->chapter_name}} Crest"
                     height="100px" width="100px" data-src="{{asset('/crests/' . $detail->hull_number . '.svg')}}">
            </div>
        @endif
        <div class="columns small-10 end">
            <h2 class="Incised901Bold padding-5">{{ $detail->chapter_name }} {{$hull_number}}</h2>
            <h3 class="Incised901Bold padding-5">{{ isset($detail->ship_class) ? $detail->ship_class . ' Class' : '' }}</h3>
        </div>
    </div>



    <div class="row padding-5">
        <div class="small-2 columns Incised901Light">
            Chapter Name:
        </div>
        <div class="small-10 columns Incised901Light">
            {{ $detail->chapter_name }} {{$hull_number}}
        </div>
    </div>
    <div class="row padding-5">
        <div class="small-2 columns Incised901Light">
            Chapter Type:
        </div>
        <div class="small-10 columns Incised901Light">
            {{ucfirst($detail->chapter_type)}}
            @if(in_array($detail->chapter_type, ['ship', 'station']) === true)
               @if(empty($detail->decommission_date) === true)
                    (Commissoned {{date('F jS, Y', strtotime($detail->commission_date))}})
               @else
                    (Decommissoned {{date('F jS, Y', strtotime($detail->decommission_date))}})
                @endif
            @endif
        </div>
    </div>
    @if($higher)
        <?php
        $higherType = Chapter::getChapterType($higher->_id);

        if (( in_array($higherType,['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true ) && isset( $higher->hull_number ) === true) {
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
                <a href="{{route('chapter.show', $higher->_id)}}">{{$higher->chapter_name}} {{$higherHullNumber}}</a>
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
                    $elementType = Chapter::getChapterType($chapter['_id']);

                    if (( in_array($elementType,['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true ) && isset( $chapter['hull_number'] ) === true) {
                        $elementHullNumber = ' (' . $chapter['hull_number'] . ')';
                    } else {
                        $elementHullNumber = '';
                    }
                    ?>
                    <a href="{{route('chapter.show', [$chapter['_id']])}}">{{ $chapter['chapter_name'] }}{{$elementHullNumber}}</a>
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
                    @if($detail->chapter_type == 'fleet')Fleet Commander:
                    @else
                        Commanding Officer:
                    @endif
                    @if( isset( $command['CO'] ) )
                        <a href="{{ route('user.show' , [(string)$command['CO']->_id]) }}">{{ $command['CO']->getGreeting() }} {{ $command['CO']->first_name }}{{ isset($command['CO']->middle_name) ? ' ' . $command['CO']->middle_name : '' }} {{ $command['CO']->last_name }}{{ !empty($command['CO']->suffix) ? ' ' . $command['CO']->suffix : '' }}, {{$command['CO']->branch}}</a>
                    @else
                        N/A
                    @endif
                </div>
                @if(Auth::user()->getPrimaryAssignmentId() == $detail->id || Auth::user()->getSecondaryAssignmentId() == $detail->id || $permsObj->hasPermissions(['VIEW_MEMBERS']))
                <div style="padding-bottom: 2px;">
                    @if($detail->chapter_type == 'fleet')Deputy Fleet Commander:
                    @else
                        Executive Officer:
                    @endif
                    @if( isset( $command['XO'] ) )
                        <a href="{{ route('user.show' , [(string)$command['XO']->id]) }}">{{ $command['XO']->getGreeting() }} {{ $command['XO']->first_name }}{{ isset($command['XO']->middle_name) ? ' ' . $command['XO']->middle_name : '' }} {{ $command['XO']->last_name }}{{ !empty($command['XO']->suffix) ? ' ' . $command['XO']->suffix : '' }}, {{$command['XO']->branch}}</a>
                    @else
                        N/A
                    @endif
                </div>
                <div style="padding-bottom: 2px;">
                    @if($detail->chapter_type == 'fleet')Fleet
                    @endif
                        Bosun:
                    @if( isset( $command['BOSUN'] ) )
                        <a href="{{ route('user.show' , [(string)$command['BOSUN']->id]) }}">{{ $command['BOSUN']->getGreeting() }} {{ $command['BOSUN']->first_name }}{{ isset($command['BOSUN']->middle_name) ? ' ' . $command['BOSUN']->middle_name : '' }} {{ $command['BOSUN']->last_name }}{{ !empty($command['BOSUN']->suffix) ? ' ' . $command['BOSUN']->suffix : '' }}, {{$command['BOSUN']->branch}}</a>
                    @else
                        N/A
                    @endif
                </div>
                @endif
            </div>
        </div>
    @endif
    @if (count($crew) > 0 && (Auth::user()->getPrimaryAssignmentId() == $detail->id || Auth::user()->getSecondaryAssignmentId() == $detail->id || $permsObj->hasPermissions(['VIEW_MEMBERS'])))
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light">
                Crew Roster:
            </div>
            <div class="small-10 columns Incised901Light">
                <table id="crewRoster" class="compact row-border" width="75%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Rank</th>
                        <th>Billet</th>
                        <th>Branch</th>
                    </tr>
                    </thead>
                <tbody>
                @foreach($crew as $member)
                    <tr>
                        <td><a href="{{ route('user.show', [$member->_id]) }}">{{ $member->last_name }}{{ !empty($member->suffix) ? ' ' . $member->suffix : '' }}, {{ $member->first_name }}{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}</a></td>
                        <td>{{ $member->getGreeting() }}</td>
                        <td>{{ $member->getBilletForChapter($detail->id) }}</td>
                        <td>{{$member->branch}}</td>
                    </tr>
                @endforeach
                </tbody>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Rank</th>
                        <th>Billet</th>
                        <th>Branch</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

@stop
