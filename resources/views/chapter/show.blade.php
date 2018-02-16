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
            <div class=" col-sm-2">
                <img class='crest' src="{!!asset($path . $detail->hull_number . '.svg')!!}"
                     alt="{!!$detail->chapter_name!!} Crest"
                     width="100px" data-src="{!!asset($path . $detail->hull_number . '.svg')!!}">
            </div>
        @endif
        <div class=" col-sm-10 ">
            <h2 class="Incised901Bold padding-5">
                @if(in_array($detail->chapter_type, ['barony', 'county', 'duchy', 'grand_duchy']))
                    {!!App\Type::where('chapter_type', '=', $detail->chapter_type)->first()->chapter_description!!} of
                @endif
                {!! $detail->chapter_name !!} @if((in_array($detail->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($detail->hull_number) === true) ({!!$detail->hull_number!!}
                ) @endif @if(empty($detail->idcards_printed) && $permsObj->hasPermissions(['ID_CARD']))
                    <a class="fa fa-credit-card green size-24" href="/id/bulk/{!!$detail->id!!}"
                       data-toggle="tooltip" title="Print ID Cards"></a>
                    <a class="fa fa-check green size-24" href="/id/markbulk/{!!$detail->id!!}"
                       data-toggle="tooltip" title="Mark ID Cards as printed"
                       onclick="return confirm('Mark ID cards as printed for this chapter?')"></a>
                @elseif(!empty($detail->idcards_printed) && $permsObj->hasPermissions(['ID_CARD']))
                    <span class="fa fa-print size-24" data-toggle="tooltip" title="ID Cards printed"></span> @endif
            </h2>

            <h3 class="Incised901Bold padding-5">{!! isset($detail->ship_class) ? $detail->ship_class . ' Class' : '' !!}</h3>
        </div>
    </div>

    @if(!in_array($detail->chapter_type, ['keep', 'barony', 'county', 'duchy', 'grand_duchy', 'steading']))
        <div class="row padding-5">
            <div class="col-sm-2  Incised901Light ninety text-right">
                Chapter Type:
            </div>
            <div class="col-sm-10  Incised901Light ninety">
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
            <div class="col-sm-2  Incised901Light ninety text-right">
                Component of:
            </div>
            <div class="col-sm-10  Incised901Light ninety">
                <a href="{!!route('chapter.show', $higher->_id)!!}">{!!$higher->chapter_name!!}@if((in_array($higher->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($higher->hull_number) === true) ({!!$higher->hull_number!!})@endif</a>
            </div>
        </div>
    @endif
    @if (count($includes) > 0)
        <div class="row padding-5">
            <div class="col-sm-2  Incised901Light ninety text-right">
                Elements:
            </div>
            <div class="col-sm-10  Incised901Light ninety">
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
            <div class="col-sm-7 text-center">
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
                <div class=" col-sm-2 Incised901Light text-right">
                    {!!$info['display']!!}:
                </div>
                <div class=" col-sm-5 Incised901Light">
                    @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                        <a href="{!! route('user.show' , [$info['user']->id]) !!}">
                            @endif

                            {!! trim($info['user']->getGreeting()) !!} {!! $info['user']->first_name !!}{{ isset($info['user']->middle_name) ? ' ' . $info['user']->middle_name : '' }} {!! $info['user']->last_name !!}{{ !empty($info['user']->suffix) ? ' ' . $info['user']->suffix : '' }}
                            , {!!$info['user']->branch!!}

                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                        </a>
                        @if($info['user']->hasNewExams())
                            <span class="fa fa-star red" data-toggle="tooltip" title="New Exams Posted">&nbsp</span>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    @if (count($crew) > 0 && (Auth::user()->getAssignedShip() == $detail->id || $permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true))
        <br/>
        <div class="row padding-5">
            <div class=" col-sm-10 text-center ">
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
            <div class="col-sm-10 Incised901Bold ninety">
                <div class="btn-group text-center padding-bottom-10 btn-group-sm" role="group">
                    @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                        <br/><a href="{!!route('roster.export', [$detail->id])!!}"><button class="btn btn-sm btn-primary"><span class="fa fa-download"></span> Download Roster</button></a>
                    @endif
                    @if($permsObj->canPromote($detail->id))
                            <a href="{{ route('promotions', [$detail->id]) }}"><button class="btn btn-sm btn-primary"><span class="fa fa-thumbs-up"></span> Promotions</button></a>
                    @endif
                    @if(Auth::user()->isCoAssignedShip())
                            <a href="{!!route('report.index')!!}"><button class="btn btn-sm btn-primary"><span class="fa fa-file-text-o"></span> Chapter Reports</button></a>
                            <a href="/upload/status/{{Auth::user()->getAssignedShip()}}"><button class="btn btn-sm btn-primary"><span class="fa fa-question-circle"></span> Promotion Point Status</button></a>
                            <a href="/upload/sheet/{{Auth::user()->getAssignedShip()}}"><button class="btn btn-sm btn-primary"><span class="fa fa-upload"></span> Upload Promotion Points</button></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12  Incised901Light ">
                <table id="crewRoster" class="compact row-border">
                    <thead>
                    <tr>
                        @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                            <th class="text-center green nowrap">P/P-E</th>
                        @endif
                        <th>Name</th>
                        @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                            <th>ID #</th>
                            <th>Path</th>
                            <th>Points</th>
                            <th class="text-center">Highest<br/>Courses</th>
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
                                <td class="nowrap @if($member->isPromotable() || $member->isPromotableEarly()) promotable @endif ">
                                    @if(!is_null($member->isPromotable()))
                                        <strong>P [ {{implode(', ', $member->isPromotable())}} ]</strong>
                                    @elseif(!is_null($member->isPromotableEarly()))
                                        <strong>P-E [ {{implode(', ', $member->isPromotableEarly())}} ]</strong>
                                    @endif
                                </td>
                            @endif
                            <td>
                                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                    <a href="{!! route('user.show', [$member->_id]) !!}"
                                       @if($member->isPromotable() || $member->isPromotableEarly()) class="promotable" @endif>
                                        @endif
                                        {!! $member->last_name !!}{{ !empty($member->suffix) ? ' ' . $member->suffix : '' }}
                                        , {!! $member->first_name !!}{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}
                                        @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                    </a>
                                @endif

                            </td>
                            @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                                <td class="nowrap">{!!$member->member_id!!}</td>
                                <td>{{$member->path ? ucfirst($member->path) : 'Service'}}</td>
                                <td class="text-right">{{ number_format((float)$member->getTotalPromotionPoints(), 2) }}</td>
                                <td class="nowrap">
                                    @foreach($member->getHighestExams() as $class => $exam)
                                        {{$class}}: {{$exam}}<br/>
                                    @endforeach
                                </td>
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
                            <th class="text-center green">P/P-E</th>
                        @endif
                        <th>Name</th>
                        @if($permsObj->hasPermissions(['VIEW_MEMBERS']) || $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()) === true)
                            <th>ID #</th>
                            <th>Path</th>
                            <th>Points</th>
                            <th class="text-center">Highest<br/>Courses</th>
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