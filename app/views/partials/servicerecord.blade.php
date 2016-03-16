<h4 class="trmn my">
    @if($user->registration_status != "Pending")
        Service Record
    @else
        Member Application
    @endif
</h4>
<h5 class="Incised901Light ninety">Last
    Updated: {{ date('d M Y @ g:i A T', strtotime($user->updated_at)) }}</h5>

<div id="user-profile">
    <div class="Incised901Bold">
        {{ $user->getGreeting() }}({{$user->branch}})
        {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}{{$user->getPostnominals()}}
    </div>
    <div class="NordItalic ninety padding-5">
        <a href="{{route('chapter.show',$user->getPrimaryAssignmentId())}}">
            {{$user->getPrimaryAssignmentName()}}
            <?php
            $chapterType = Chapter::getChapterType($user->getPrimaryAssignmentId());
            ?>
            @if($chapterType == "ship" || $chapterType == "station")
                {{$user->getPrimaryAssignmentDesignation()}}
            @endif
        </a>
    </div>
    @if($user->registration_status != "Pending")
        <div class="Incised901Light filePhoto">
            <a href="/id/qrcode/{{$user->id}}">{{$user->member_id}}</a>
            <div class="filePhotoBox">

                @if(file_exists(public_path() . $user->filePhoto) && isset($user->filePhoto) === true)
                    <img src="{{$user->filePhoto}}" alt="Official File Photo">
                @else
                    <div class="ofpt">Official<br/>File<br/>Photo</div>
                @endif

            </div>
            {{$user->getPrimaryBillet()}}<br/>

            <div class="Incised901Light seventy-five">Assigned: {{$user->getPrimaryDateAssigned()}}</div>
        </div>

        <div class="Incised901Black ninety">
            Time In
            Grade: {{is_null($tig = $user->getTimeInGrade())?'No Time In Grade information available at this time':$tig}}
        </div>
        <div class="Incised901Black ninety">
            Time In Service: {{$user->getTimeInService()}}
        </div>
        <div class="Incised901Black ninety">
            Additional Assignments:
        </div>

        <div class="Incised901Light whitesmoke">
            <?php
            $count = 0;
            foreach (['secondary', 'additional', 'extra'] as $position) {
                if (empty( $user->getAssignmentName($position) ) === false) {
                    echo '<a href="' . route('chapter.show', $user->getAssignmentId($position)) . '">' .
                            $user->getAssignmentName($position) . '</a>';
                    $count++;
                }

                if (empty( $user->getBillet($position) ) === false) {
                    echo ', ' . $user->getBillet($position) . '<br>';
                }
            }

            if ($count === 0) {
                echo "None<br>";
            }

            ?>
        </div>
        <br/>
        @if(count($user->getPeerages()))
            <h5 class="Incised901Black ninety">
                @if(count($user->getPeerages())>1)
                    Peerages
                @else
                    Peerage
                @endif
            </h5>
            @foreach($user->getPeerages() as $peerage)
                <div class="row">
                    <div class="small-1 columns text-left">
                        <?php
                        $path = '';

                        if ($peerage['code'] != 'K') {
                            $path = null;
                            if (empty( $peerage['filename'] ) === false) {
                                $path = '/arms/peerage/' . $peerage['filename'];
                            }
                            $fullTitle = $peerage['generation'] . ' ' . $peerage['title'] . ' of ' . $peerage['lands'];
                            $toolTip = 'Arms for ' . $fullTitle;
                        } else {
                            $orderInfo = Korders::where('classes.postnominal', '=', $peerage['postnominal'])->first();
                            $path = '/awards/orders/medals/' . $orderInfo->filename;
                            $fullTitle = $orderInfo->getClassName($peerage['postnominal']) . ', ' . $orderInfo->order;
                            $toolTip = $orderInfo->order;
                        }
                        ?>
                        @if(file_exists(public_path() . $path) === true && empty($path) === false)
                            <img class='crest' src="{{asset($path)}}"
                                 alt="{{$fullTitle}}"
                                 width="50px" title="{{$toolTip}}">
                        @else
                            &nbsp;
                        @endif
                    </div>
                    <div class="small-4 columns Incised901Light ninety text-left vertical-center-50px">
                        @if(empty($peerage['courtesy']) === false)
                            <em>
                                @endif
                                {{$fullTitle}}
                                @if(empty($peerage['courtesy']) === false)
                            </em>
                        @endif
                    </div>

                    <div class="small-1 columns end text-left vertical-center-50px">
                        @if($permsObj->hasPermissions(['EDIT_PEERAGE', 'DEL_PEERAGE']))
                            @if($permsObj->hasPermissions(['EDIT_PEERAGE']))
                                <a href="#" data-peerage-id="{{$peerage['peerage_id']}}"
                                   data-peerage-title="{{$peerage['title']}}"
                                   data-peerage-generation="{{$peerage['generation'] or ''}}"
                                   data-peerage-lands="{{$peerage['lands'] or ''}}"
                                   data-peerage-order="{{$orderInfo->id or ''}}"
                                   data-peerage-class="{{$peerage['postnominal'] or ''}}"
                                   data-peerage-courtesy="{{$peerage['courtesy'] or "0"}}"
                                   data-peerage-filename="{{$peerage['filename'] or ''}}"
                                   class="edit_peerage fi-pencil green">&nbsp;</a>
                            @endif
                            @if($permsObj->hasPermissions(['DEL_PEERAGE']))
                                <a href="#" data-peerage-text="{{$fullTitle}}" data-user-id="{{$user->id}}"
                                   data-peerage-id="{{$peerage['peerage_id']}}" class="delete_peerage fi-x red">
                                    &nbsp;</a>
                            @endif
                        @else
                            &nbsp;
                        @endif
                    </div>

                </div>
            @endforeach
        @endif
        @if($permsObj->hasPermissions(['ADD_PEERAGE']))
            <div class="sbAccordian">
                <h5 id="peerage-container">Add Peerage</h5>
                <div class="content">
                    {{ Form::open(['route' => ['addOrEditPeerage', $user->id], 'method' => 'post', 'files' => true, 'id'=>'peerage_form']) }}
                    <div class="row">
                        <div class="small-3 columns Incised901Light ninety text-left">{{Form::select('ptitle', $ptitles, '', ['id' => 'ptitle'])}}{{Form::checkbox('courtesy', 1, null, ['id' => 'courtesy'])}}
                            <label for="courtesy" id="courtesy_label">Courtesy Title</label></div>
                        <div class="small-3 columns Incised901Light ninety text-left">
                            {{Form::select('generation',
                            ['' => 'Select Peerage Generation', 'First' => 'First', 'Second' => 'Second', 'Third' => 'Third', 'Fourth' => 'Fourth', 'Fifth'=> 'Fifth'], '',
                            ['id' => 'generation'])}}
                            {{Form::select('order', $korders, '',['id' => 'order'])}}
                        </div>
                        <div class="small-3 columns Incised901Light ninety text-left end">
                            {{Form::text('lands', null, ['placeholder' => 'Name of Peerage Lands', 'id' => 'lands'])}}
                            {{Form::select('class', ['' => 'Select Class'], null, ['id' => 'class'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-3 columns incised901light ninety text-left">
                            {{Form::label('arms','Upload Peerage Arms', ['id'=>'arms-label'])}}
                            {{Form::file('arms', ['id' => 'arms'])}}
                        </div>
                        <div class="small-3 columns Incised901Light ninety text-left end">
                            <button class="button round" id="cancel">Cancel
                            </button> {{Form::submit('Save Peerage', ['id' => 'save_peerage', 'class' => 'button round'])}}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
        <h5 class="Incised901Black ninety">
            Academy Coursework:
        </h5>

        <div class="whitesmoke">
            @if($user->getExamLastUpdated() !== false)
                <span class="Incised901Light ninety">Last
                        Updated: {{ date('d M Y @ g:i A T', strtotime($user->getExamLastUpdated())) }}</span>
            @endif
            <div class="sbAccordian">
                @foreach(['RMN', 'SRN', 'GSN', 'STC|AFLTC|GTSC', 'RMMC', 'SRMC', 'RMA', 'RMAT', 'CORE|KC|QC'] as $branch)
                    @if(count($user->getExamList(['branch' => $branch])) > 0)
                        @if($branch == 'SRN')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">RMN Speciality</h5>
                        @elseif($branch == 'SRMC')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">RMMC Speciality</h5>
                        @elseif($branch == 'RMAT')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">RMA Speciality</h5>
                        @elseif($branch == 'CORE|KC|QC')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">Landing University</h5>
                        @elseif($branch == 'STC|AFLTC|GTSC')
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">GSN Speciality</h5>
                        @else
                            <h5 class="Incised901Light ninety" title="Click to expand/collapse">{{$branch}}</h5>
                        @endif
                        <div class="content">
                            @foreach($user->getExamList(['branch' => $branch]) as $exam => $gradeInfo)
                                <div class="row">
                                    <div class="small-3 columns Incised901Light ninety textLeft">{{$exam}}</div>
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
    @endif
    <br/>
    @if($permsObj->hasPermissions(['DOB']) || ($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id))
        <div class="Incised901Light ninety">Date of Birth: {{date('d M Y', strtotime($user->dob))}}</div>
        <br />
    @endif

    <div class="Incised901Black ninety">
        Contact:
        <div class="row">
            <div class="small-1 columns Incised901Light ninety">&nbsp;</div>
            <div class="small-10 columns Incised901Light ninety textLeft end">
                {{ $user->address1 }}<br/>
                @if(!empty($user->address2))
                    {{ $user->address2 }}<br/>
                @endif
                {{ $user->city }}, {{ $user->state_province }} {{ $user->postal_code }}<br/>
                {{ $user->email_address }}<br/>
                {{ isset($user->phone_number) ? $user->phone_number . '<br />' : '' }}
            </div>
        </div>
        <div class="row">
            <div class="small-1 columns Incised901Light ninety">&nbsp;</div>
            <div class="small-10 columns Incised901Light ninety textLeft end">
                <br/>
                @if($user->registration_status != "Pending" && (($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || ($permsObj->hasPermissions(['EDIT_MEMBER']))))
                    <a href="{{route('user.edit', [$user->_id])}}" class="editButton Incised901Black margin-5">EDIT</a>
                @elseif($permsObj->hasPermissions(['PROC_APPLICATIONS']))
                    <a href="{{action('user.approve', [$user->_id])}}" class="editButton Incised901Black margin-5">Approve</a>
                    <a href="{{action('user.deny', [$user->_id])}}" class="editButton
                        Incised901Black margin-5">DENY</a>
                @endif
            </div>
        </div>
    </div>
</div>