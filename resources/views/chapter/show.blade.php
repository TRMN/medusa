@extends('layout')

@section('pageTitle')
    {!! $detail->chapter_name !!} @if((in_array($detail->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($detail->hull_number) === true) ({!!$detail->hull_number!!}) @endif
@stop

@section('content')
    <div class="row">
        <?php
        if ($detail->chapter_type == 'fleet') {
            $path = '/crests/fleet/';
        } else {
            $path = '/crests/';
        }
        ?>
        @if(file_exists(public_path() . $path . $detail->hull_number . '.svg') === true)
            <div class="columns small-2">
                <img class='crest' src="{!!asset($path . $detail->hull_number . '.svg')!!}"
                     alt="{!!$detail->chapter_name!!} Crest"
                     width="100px" data-src="{!!asset($path . $detail->hull_number . '.svg')!!}">
            </div>
        @endif
        <div class="columns small-10 end">
            <h2 class="Incised901Bold padding-5">
                @if(in_array($detail->chapter_type, ['barony', 'county', 'duchy', 'grand_duchy']))
                    {!!App\Type::where('chapter_type', '=', $detail->chapter_type)->first()->chapter_description!!} of
                @endif
                {!! $detail->chapter_name !!} @if((in_array($detail->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($detail->hull_number) === true) ({!!$detail->hull_number!!}
                ) @endif @if(empty($detail->idcards_printed) && $permsObj->hasPermissions(['ID_CARD']))
                    <a class="fi-credit-card green size-24" href="/id/bulk/{!!$detail->id!!}"
                       title="Print ID Cards"></a>
                    <a class="fi-check green size-24" href="/id/markbulk/{!!$detail->id!!}"
                       title="Mark ID Cards as printed"
                       onclick="return confirm('Mark ID cards as printed for this chapter?')"></a>
                @elseif(!empty($detail->idcards_printed) && $permsObj->hasPermissions(['ID_CARD']))
                    <span class="fi-print size-24" title="ID Cards printed"></span> @endif
            </h2>

            <h3 class="Incised901Bold padding-5">{!! isset($detail->ship_class) ? $detail->ship_class . ' Class' : '' !!}</h3>
        </div>
    </div>

    @if(!in_array($detail->chapter_type, ['keep', 'barony', 'county', 'duchy', 'grand_duchy', 'steading']))
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light ninety text-right">
                Chapter Type:
            </div>
            <div class="small-10 columns Incised901Light ninety">
                {!!App\Type::where('chapter_type', '=', $detail->chapter_type)->first()->chapter_description!!}
                @if(in_array($detail->chapter_type, ['ship', 'station']) === true)
                    @if(empty($detail->decommission_date) === true)
                        (Commissoned {!!date('F jS, Y', strtotime($detail->commission_date))!!})
                    @else
                         (Decommissoned {!!date('F jS, Y', strtotime($detail->decommission_date))!!})
                    @endif
                @endif
            </div>
        </div>
    @endif

    @if($higher)
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light ninety text-right">
                Component of:
            </div>
            <div class="small-10 columns Incised901Light ninety">
                <a href="{!!route('chapter.show', $higher->_id)!!}">{!!$higher->chapter_name!!}@if((in_array($higher->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($higher->hull_number) === true) ({!!$higher->hull_number!!})@endif</a>
            </div>
        </div>
    @endif
    @if (count($includes) > 0)
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light ninety text-right">
                Elements:
            </div>
            <div class="small-10 columns Incised901Light ninety">
                @foreach($includes as $chapter)
                    <a href="{!!route('chapter.show', [$chapter->id])!!}">{!! $chapter->chapter_name !!}@if((in_array($chapter->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($chapter->hull_number) === true) ({!!$chapter->hull_number!!}) @endif</a>
                    &nbsp;<br/>
                @endforeach
            </div>
        </div>
    @endif

    @if (count($command) > 0)
        <br/>
        <div class="row">
            <div class="columns small-7 end text-center">
                <h3 class="Incised901Light">
                    @if(in_array($detail->chapter_type, ['keep', 'barony', 'county', 'duchy', 'grand_duchy', 'steading']))
                        {!!App\Type::where('chapter_type', '=', $detail->chapter_type)->first()->chapter_description!!}
                    @else
                        Command
                    @endif
                    Staff</h3>
            </div>
        </div>
        @foreach($command as $info)
            <div class="row">
                <div class="columns small-2 Incised901Light text-right">
                    {!!$info['display']!!}:
                </div>
                <div class="columns small-5 end Incised901Light">
                    @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                        <a href="{!! route('user.show' , [$info['user']->id]) !!}">
                            @endif

                            {!! trim($info['user']->getGreeting()) !!} {!! $info['user']->first_name !!}{{ isset($info['user']->middle_name) ? ' ' . $info['user']->middle_name : '' }} {!! $info['user']->last_name !!}{{ !empty($info['user']->suffix) ? ' ' . $info['user']->suffix : '' }}
                            , {!!$info['user']->branch!!}

                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                        </a>
                        @if($info['user']->hasNewExams())
                            <span class="fi-star red" title="New Exams Posted">&nbsp</span>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    @if (count($crew) > 0 && (Auth::user()->getAssignedShip() == $detail->id || $permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true))
        <br/>
        <div class="row padding-5">
            <div class="columns small-10 text-center end">
                <h3 class="Incised901Light">
                    @if(in_array($detail->chapter_type, ['keep', 'barony', 'county', 'duchy', 'grand_duchy', 'steading']))
                        {!!App\Type::where('chapter_type', '=', $detail->chapter_type)->first()->chapter_description!!}
                        Members
                    @else
                        Crew Roster
                    @endif</h3>
            </div>
        </div>
        <div class="row padding-5">
            <div class="small-10 end columns Incised901Light ninety">
                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                    <br/><a href="{!!route('roster.export', [$detail->id])!!}">Download Roster</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="small-10 columns Incised901Light end">
                <table id="crewRoster" class="compact row-border">
                    <thead>
                        <tr>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <th class="center" width="20"><span class="fi-star red"
                                                                    title="New Exams Posted">&nbsp;</span></th>
                            @endif
                            <th>Name</th>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <th>ID #</th>
                            @endif
                            <th>Rank</th>
                            <th class="text-center">Time in Grade</th>
                            <th>Billet</th>
                            <th>Branch</th>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <th>City</th>
                                <th>State / Province</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($crew as $member)
                            <tr class="zebra-odd">
                                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                    <td class="center">@if($member->hasNewExams()) <span class="fi-star red"
                                                                                         title="New Exams Posted">&nbsp;</span> @endif
                                    </td>
                                @endif
                                <td>
                                    @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                        <a href="{!! route('user.show', [$member->_id]) !!}">
                                            @endif
                                            {!! $member->last_name !!}{{ !empty($member->suffix) ? ' ' . $member->suffix : '' }}
                                            , {!! $member->first_name !!}{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}
                                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                        </a>

                                    @endif
                                </td>
                                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                    <td>{!!$member->member_id!!}</td>
                                @endif
                                <td>{!!$member->rank['grade']!!} <br/>{!! $member->getGreeting() !!} </td>
                                <td>{!!is_null($tig = $member->getTimeInGrade(true))?'N/A':$tig!!}</td>
                                <td>{!! $member->getBilletForChapter($detail->id) !!}</td>
                                <td>{!!$member->branch!!}</td>
                                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                    <td>{!!$member->city!!}</td>
                                    <td>{!!$member->state_province!!}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <th class="center"><span class="fi-star red" title="New Exams Posted">&nbsp;</span></th>
                            @endif
                            <th>Name</th>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <th>ID #</th>
                            @endif
                            <th>Rank</th>
                            <th style="text-align: center">Time in Grade</th>
                            <th>Billet</th>
                            <th>Branch</th>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <th>City</th>
                                <th>State / Province</th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

@stop
@section('scriptFooter')
    <script type="text/javascript">
        $('#crewRoster').DataTable({
            "autoWidth": true,
            "pageLength": 25,
            "language": {
                "emptyTable": "No crew members found"
            },
            "$UI": true
            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
            , "order": [[0, "desc"]]
            @endif
        });
    </script>
@stop