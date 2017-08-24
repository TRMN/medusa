<br/>
<h5 class="Incised901Black ninety">
    Academy Coursework: @if($user->getExamLastUpdated() !== false)
        <span class="Incised901Light ninety">( Last
                        Updated: {!! date('d M Y @ g:i A T', strtotime($user->getExamLastUpdated())) !!} )</span>
    @endif
</h5>

<div class="whitesmoke">

    <div class="sbAccordian">
        @foreach(\App\MedusaConfig::get('exam.regex') as $school => $regex)
            @if(count($user->getExamList(['pattern' => $regex])) > 0)
                <h5 class="Incised901Light ninety" data-toggle="tooltip" title="Click to expand/collapse" data-placement="left">{!!$school!!}
                    @if($user->hasNewExams($regex))
                        &nbsp;<strong class="yellow">(New exams posted)</strong>
                    @endif
                </h5>
                <div>
                    @foreach($user->getExamList(['pattern' => $regex]) as $exam => $gradeInfo)
                        <div class="row">
                            <div class="col-sm-6  Incised901Light ninety textLeft @if(!empty($gradeInfo['date_entered']) && (strtotime($gradeInfo['date_entered']) >= strtotime(Auth::user()->getLastLogin())))yellow @endif">{!!$exam!!} @if (!is_null(App\ExamList::where('exam_id','=',$exam)->first())){!!App\ExamList::where('exam_id','=',$exam)->first()->name!!}@endif</div>
                            <div class="col-sm-1  Incised901Light ninety textRight">{!!$gradeInfo['score']!!}</div>
                            <div class="col-sm-3  Incised901Light ninety textRight">@if($gradeInfo['date'] != 'UNKNOWN')
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
