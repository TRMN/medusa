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
        {{ $user->getGreeting() }} {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}
        , {{$user->branch}}
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
            {{$user->member_id}}
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
            foreach (['secondary', 'additional'] as $position) {
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

        <h5 class="Incised901Black ninety">
            Academy Coursework:
        </h5>

        <div class="whitesmoke">
            @if($user->getExamLastUpdated() !== false)
                <span class="Incised901Light ninety">Last
                        Updated: {{ date('d M Y @ g:i A T', strtotime($user->getExamLastUpdated())) }}</span>
            @endif
            <div class="sbAccordian">
                @foreach(['RMN', 'SRN', 'GSN', 'RMMC', 'RMC', 'RMA'] as $branch)
                    @if(count($user->getExamList(['branch' => $branch])) > 0)
                        @if($branch == 'SRN')
                           <h5 class="Incised901Light ninety">RMN Speciality</h5>
                        @elseif($branch == 'RMC')
                            <h5 class="Incised901Light ninety">RMMC Speciality</h5>
                        @else
                            <h5 class="Incised901Light ninety">{{$branch}}</h5>
                        @endif
                        <div class="content">
                            @foreach($user->getExamList(['branch' => $branch]) as $exam => $gradeInfo)
                                <div class="row">
                                    <div class="small-3 columns Incised901Light ninety textLeft">{{$exam}}</div>
                                    <div class="small-1 columns Incised901Light ninety textRight">{{$gradeInfo['score']}}</div>
                                    <div class="small-2 columns Incised901Light ninety end textRight">@if($gradeInfo['date'] != 'UNKNOWN')
                                            {{date('d M Y', strtotime($gradeInfo['date']))}}
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