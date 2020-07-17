@extends('layout')

@section('dochead')
    <style>
        ul {
            margin: 0 0 0 20px !important;
            list-style: none !important;
            line-height: 2em !important;
        }

        ul li.tree {
            position: relative !important;
        }

        ul li.tree:before {
            position: absolute !important;
            left: -15px !important;
            top: 0 !important;
            content: '' !important;
            display: block !important;
            border-left: 1px solid #ddd !important;
            height: 1em !important;
            border-bottom: 1px solid #ddd !important;
            width: 10px !important;
        }

        ul li.tree:after {
            position: absolute !important;
            left: -15px !important;
            bottom: -7px !important;
            content: '' !important;
            display: block !important;
            border-left: 1px solid #ddd !important;
            height: 100% !important;
        }

        ul li.root {
            margin: 0 0 0 -20px !important;
        }

        ul li.root:before {
            display: none !important;
        }

        ul li.root:after {
            display: none !important;
        }

        ul li:last-child:after {
            display: none !important;
        }
    </style>
@stop
@section('pageTitle')
    {!! $detail->chapter_name !!} @if((in_array($detail->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($detail->hull_number) === true) ({!!$detail->hull_number!!}) @endif
@stop

@section('content')
    <div class="row">
        @if($detail->chapter_type == 'fleet')
            @set('path', '/crests/fleet/')
        @else
            @set('path', '/crests/')
        @endif
        @set('isInChainOfCommand', $permsObj->isInChainOfCommand($detail->getChapterIdWithParents()))
        @set('viewMembers', $permsObj->hasPermissions(['VIEW_MEMBERS']))
        @set('idCard', $permsObj->hasPermissions(['ID_CARDS']))
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
                ) @endif @if(empty($detail->idcards_printed) && $idCard)
                    <a class="fa fa-credit-card green size-24" href="/id/bulk/{!!$detail->id!!}"
                       data-toggle="tooltip" title="Print ID Cards"></a>
                    <a class="fa fa-check green size-24" href="/id/markbulk/{!!$detail->id!!}"
                       data-toggle="tooltip" title="Mark ID Cards as printed"
                       onclick="return confirm('Mark ID cards as printed for this chapter?')"></a>
                @elseif(!empty($detail->idcards_printed) && $idCard)
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
    @if (!empty($includes))
        <div class="row padding-5">
            <div class="col-sm-2  Incised901Light ninety text-right">
                Elements:
            </div>
            <div class="col-sm-10  Incised901Light">
                <ul id="elements">
                    @foreach($includes as $element)
                        @include('chapter.child', ['element' => $element, 'collapse' => true])
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (!empty($command))
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
                    @if($viewMembers || $isInChainOfCommand === true)
                        <a href="{!! route('user.show' , [$info['user']->id]) !!}">
                            @endif

                            {!! trim($info['user']->getGreeting()) !!} {!! $info['user']->first_name !!}{{ isset($info['user']->middle_name) ? ' ' . $info['user']->middle_name : '' }} {!! $info['user']->last_name !!}{{ !empty($info['user']->suffix) ? ' ' . $info['user']->suffix : '' }}
                            , {!!$info['user']->branch!!}

                            @if($viewMembers || $isInChainOfCommand === true)
                        </a>
                        @if($info['user']->hasNewExams())
                            <span class="fa fa-star red" data-toggle="tooltip" title="New Exams Posted">&nbsp</span>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    @if (Auth::user()->getAssignedShip() == $detail->id || $viewMembers || $isInChainOfCommand === true)
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
                    @if($viewMembers || $isInChainOfCommand === true)
                        <br/><a href="{!!route('roster.export', [$detail->id])!!}">
                            <button class="btn btn-sm btn-primary"><span class="fa fa-download"></span> Download Roster
                            </button>
                        </a>
                    @endif
                    @if($permsObj->canPromote($detail->id))
                        <a href="{{ route('promotions', [$detail->id]) }}">
                            <button class="btn btn-sm btn-primary"><span class="fa fa-thumbs-up"></span> Promotions
                            </button>
                        </a>
                    @endif
                    @if(Auth::user()->hasPermissions(['CHAPTER_REPORT',]) === true)
                        <a href="{!!route('report.index')!!}">
                            <button class="btn btn-sm btn-primary"><span class="fa fa-file-text-o"></span> Chapter
                                Reports
                            </button>
                        </a>
                        <a href="/upload/sheet/{{$detail->id}}">
                            <button class="btn btn-sm btn-primary"><span class="fa fa-upload"></span> Upload Promotion
                                Points
                            </button>
                        </a>
                        <a href="/upload/status/{{$detail->id}}">
                            <button class="btn btn-sm btn-primary"><span class="fa fa-question-circle"></span> Promotion
                                Point Status
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12  Incised901Light ">
                <table id="crewRoster" class="compact row-border">
                    <thead>
                    <tr>
                        @if($viewMembers || $isInChainOfCommand === true)
                            <th class="text-center green nowrap">P/P-E</th>
                        @endif
                        <th>Name</th>
                        @if($viewMembers || $isInChainOfCommand === true)
                            <th class="nowrap">ID #</th>
                            <th>Path</th>
                            <th class="text-right">Points</th>
                            <th class="nowrap text-center roster-narrow-1300">Highest<br/>Courses</th>
                        @endif
                        <th>Rank</th>
                        <th class="text-center roster-narrow-1045">Time in Grade</th>
                        <th class="roster-narrow-1160">Billet</th>
                        <th>Branch</th>
                        @if($viewMembers || $isInChainOfCommand === true)
                            <th>City</th>
                            <th>State / Province</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    @if($viewMembers || $isInChainOfCommand === true)
                        <th class="text-center green nowrap">P/P-E</th>
                    @endif
                    <th>Name</th>
                    @if($viewMembers || $isInChainOfCommand === true)
                        <th class="nowrap">ID #</th>
                        <th>Path</th>
                        <th class="text-right">Points</th>
                        <th class="nowrap text-center roster-narrow-1300">Highest<br/>Courses</th>
                    @endif
                    <th>Rank</th>
                    <th class="text-center roster-narrow-1045">Time in Grade</th>
                    <th class="roster-narrow-1160">Billet</th>
                    <th>Branch</th>
                    @if($viewMembers || $isInChainOfCommand === true)
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
        $(document).ready(function ($) {
            $('#elements').accordion({
                active: true,
                collapsible: true,
                header: "strong",
                heightStyle: "content",
                icons: false,
                activate: function (event, ui) {
                    if (typeof ui.oldHeader[0] !== 'undefined') {
                        ui.oldHeader[0].innerText = '(Expand)';
                    }

                    if (typeof ui.newHeader[0] !== 'undefined') {
                        ui.newHeader[0].innerText = '(Collapse)';
                    }
                }
            });

            $('#crewRoster').DataTable({
                "autoWidth": false,
                "pageLength": 10,
                "language": {
                    "emptyTable": "No crew members found"
                },
                "serverSide": true,
                "ajax": {
                    url: '/chapter/{{$detail->id}}/getRoster',
                    type: 'post'
                },
                "columnDefs": [{
                    @if($viewMembers || $isInChainOfCommand)
                    "targets": [4, 5, 7, 8],
                    @else
                    "targets": [2, 3],
                    @endif
                    "orderable": false,
                    "searchable": false
                },
                        @if($viewMembers || $isInChainOfCommand)
                    {
                        className: 'text-right', targets: [4]
                    },
                    {
                        className: 'nowrap', targets: [0, 2]
                    },
                    {
                        className: 'nowrap roster-narrow-1300', targets: [5]
                    },
                        @endif
                    {
                        @if($viewMembers || $isInChainOfCommand)
                        targets: [7],
                        @else
                        targets: [2],
                        @endif
                        className: 'roster-narrow-1045'
                    },
                    {
                        @if($viewMembers || $isInChainOfCommand)
                        targets: [8],
                        @else
                        targets: [3],
                        @endif
                        className: 'roster-narrow-1160'
                    }
                ],
                @if($viewMembers || $isInChainOfCommand)
                "order": [[0, 'desc']],
                @else
                "order": [[0, 'asc']],
                @endif
                "$UI": true,
                "stripeClasses": ['zebra-odd']
            });

            $('#crewRoster').on('draw.dt', function () {
                $('#right').height(240 + $('#crewRoster').height());

                if ($('#right').height() < $('#left').height()) {
                    $('#right').height($('#left').height());
                }
            });

            if ($(window).width() < 1560) {
                $('#left').toggle();

                var toggleState = $('#toggle-btn').hasClass('fa-angle-double-left');

                if (toggleState === true) {
                    // Change to a right arrow
                    $('#toggle-btn').removeClass('fa-angle-double-left');
                    $('#toggle-btn').addClass('fa-angle-double-right');
                    $('#right-wrapper').removeClass('col-sm-10');
                    $('#right-wrapper').addClass('col-sm-12');
                } else {
                    // Change to a left arrow
                    $('#toggle-btn').removeClass('fa-angle-double-right');
                    $('#toggle-btn').addClass('fa-angle-double-left');
                    $('#right-wrapper').removeClass('col-sm-12');
                    $('#right-wrapper').addClass('col-sm-10');
                }
            }
        });
    </script>
@stop