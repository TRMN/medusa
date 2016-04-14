<br />
        <h5 class="Incised901Black ninety">
            Academy Coursework: @if($user->getExamLastUpdated() !== false)
                <span class="Incised901Light ninety">( Last
                        Updated: {{ date('d M Y @ g:i A T', strtotime($user->getExamLastUpdated())) }} )</span>
            @endif
        </h5>

        <div class="whitesmoke">

            <div class="sbAccordian">
                @foreach(['RMN', 'SRN', 'GSN', 'STC|AFLTC|GTSC', 'RMMC', 'SRMC', 'RMA', 'RMAT', 'CORE|KC|QC'] as $branch)
                    @if(count($user->getExamList(['branch' => $branch])) > 0)
                        @if($branch == 'SRN')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">RMN Specialty</h5>
                        @elseif($branch == 'SRMC')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">RMMC Specialty</h5>
                        @elseif($branch == 'RMAT')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">RMA Specialty</h5>
                        @elseif($branch == 'CORE|KC|QC')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">Landing University</h5>
                        @elseif($branch == 'STC|AFLTC|GTSC')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">GSN Specialty</h5>
                        @else
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">{{$branch}}</h5>
                        @endif
                        <div class="content">
                            @foreach($user->getExamList(['branch' => $branch]) as $exam => $gradeInfo)
                                <div class="row">
                                    <div class="small-5 columns Incised901Light ninety textLeft">{{$exam}} {{ExamList::where('id','=',$exam)->first()->name}}</div>
                                    <div class="small-1 columns Incised901Light ninety textRight">{{$gradeInfo['score']}}</div>
                                    <div class="small-2 columns Incised901Light ninety end textRight">@if($gradeInfo['date'] != 'UNKNOWN')
                                            {{date('d M Y', strtotime($gradeInfo['date']))}}
                                        @else
                                            {{$gradeInfo['date']}}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>