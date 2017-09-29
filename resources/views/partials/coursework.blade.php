<h4 class="Incised901Black">
    Academy Coursework: @if($user->getExamLastUpdated() !== false)
        <span class="Incised901Light">Last
                        Updated: {!! date('d M Y @ g:i A T', strtotime($user->getExamLastUpdated())) !!}</span>
    @endif
    @if($permsObj->hasPermissions(['ADD_GRADE']))
        <br/>
        Overall GPA: {{ $user->getGPA('/.*/') }}%
    @endif
</h4>

<h4>Space Warfare Pin earned: {{($user->hasAward('ESWP') || $user->hasAward('OSWP')) ? 'Yes': 'No'}}<br/>
    Manticoran Combat Action Medals earned: {!! $user->hasAward('MCAM') ? $user->awards['MCAM']['count'] .
    '<br />Number of courses need for next MCAM:&nbsp;<div class="progress" style="width: 25%; height: 25px">
  <div class="progress-bar progress-bar-success progress-bar-striped" style="width: ' . $user->percentNextMcamDone() .'%">
  </div>
  <div class="progress-bar progress-bar-danger progress-bar-striped" style="font-size: 18px; padding-top: 2px; width: ' . $user->percentNextMcamLeft() . '%">
<strong>' . $user->numToNextMcam() . '</strong>
  </div>
</div>' : '0' !!}<br/>

    (<em>May include additional awards that have not been issued yet</em>)</h4>

<div>
    <ul class="nav nav-tabs" role="tablist">
        @foreach(\App\MedusaConfig::get('exam.regex') as $school => $regex)
            @if(count($user->getExamList(['pattern' => $regex])) > 0)
                <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}><a
                            href="#{{str_replace(' ', '', $school)}}" aria-controls="{{str_replace(' ', '', $school)}}"
                            role="tab" data-toggle="tab">{{$school}}</a>@if($user->hasNewExams($regex))
                        <span class="fa fa-star red"></span>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach(\App\MedusaConfig::get('exam.regex') as $school => $regex)
            @if(count($user->getExamList(['pattern' => $regex])) > 0)
                <div role="tabpanel" class="tab-pane padding-top-10{{$loop->first ? ' active' : ''}}"
                     id="{{str_replace(' ', '', $school)}}">
                    @foreach($user->getExamList(['pattern' => $regex]) as $exam => $gradeInfo)
                        <div class="row zebra-odd">
                            <div class="col-sm-6  Incised901Light text-left @if(!empty($gradeInfo['date_entered']) && (strtotime($gradeInfo['date_entered']) >= strtotime(Auth::user()->getLastLogin())))yellow @endif">{!!$exam!!} @if (!is_null(App\ExamList::where('exam_id','=',$exam)->first())){!!App\ExamList::where('exam_id','=',$exam)->first()->name!!}@endif</div>
                            <div class="col-sm-1  Incised901Light text-right">{!!$gradeInfo['score']!!}</div>
                            <div class="col-sm-3  Incised901Light text-right">@if($gradeInfo['date'] != 'UNKNOWN')
                                    {!!date('d M Y', strtotime($gradeInfo['date']))!!}
                                @else
                                    {!!$gradeInfo['date']!!}
                                @endif
                            </div>
                            <div class="col-sm-2  ">
                                @if($permsObj->hasPermissions(['EDIT_GRADE']) === true)
                                    <a href="javascript:void(0);" class="fa fa-trash red delete-exam"
                                       data-fullName="{!!$user->getFullName()!!}" data-examID="{!!$exam!!}"
                                       data-memberNumber="{!!$user->member_id!!}" data-toggle="tooltip"
                                       title="Delete exam from members record">&nbsp;</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($permsObj->hasPermissions(['ADD_GRADE']))
                        <div class="row zebra-odd">
                            <div class="col-sm-6">&nbsp;</div>
                            <div class="col-sm-1 top-border-double text-right padding-top-10">
                                GPA: {{ $user->getGPA($regex) }}%
                            </div>
                        </div>

                        @if(str_replace(' ', '', $school) === $school)
                            <div class="row padding-top-10 padding-bottom-10">
                                <div class="col-sm-12 text-center bottom-border-double">
                                    GPA Breakdown
                                </div>
                            </div>
                            <div class="row">
                                @foreach($user->getGpaBySchool($school) as $course => $gpa)
                                    <div class="col-sm-3 text-center">
                                        {{ucfirst($course)}}<br/>{{$gpa}}%
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</div>

<div id="confirmExamDelete" class="modal fade" aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalTitle">Delete Exam</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="confirmMessage">

                </div>
                <div class="row">
                    <form action="/exam/user/delete" method="post">
                        <div id="delete-exam-form"></div>
                        <br/>
                        <button class="btn btn-success" type="submit" id="examDeleteYes">Yes</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
