@if( $errors->any() )
    <ul class="errors">
        @foreach( $errors->all() as $error )
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if(Session::has('message'))
    <p>{{Session::get('message')}}</p>
@endif

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
        {{ $user->getGreeting() }} {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}, {{$user->branch}}
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
        Time In Grade: {{$user->getTimeInGrade()}}
    </div>
    <div class="Incised901Black ninety">
        Time In Service: {{$user->getTimeInService()}}
    </div>
    <div class="Incised901Black ninety">
        Awards:
    </div>

    <div class="Incised901Black ninety">
        Academy Coursework:
        @if($user->getExamLastUpdated() !== false)
            <h5 class="Incised901Light ninety">Last
                Updated: {{ date('d M Y @ g:i A T', strtotime($user->getExamLastUpdated())) }}</h5>
        @endif
        @foreach($user->getExamList() as $exam => $gradeInfo)
            <div class="row">
                <div class="small-1 columns Incised901Light ninety">&nbsp;</div>
                <div class="small-2 columns Incised901Light ninety textLeft">{{$exam}}</div>
                <div class="small-2 columns Incised901Light ninety textRight">{{$gradeInfo['score']}}</div>
                <div class="small-2 columns Incised901Light ninety end textRight">{{$gradeInfo['date']}}</div>
            </div>
        @endforeach
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
                @if($user->registration_status != "Pending")
                    <a href="{{route('user.edit', [$user->_id])}}" class="editButton Incised901Black margin-5">EDIT</a>
                @else
                    <a href="{{action('user.approve', [$user->_id])}}" class="editButton Incised901Black margin-5">Approve</a> <a href="{{action('user.deny', [$user->_id])}}" class="editButton
                        Incised901Black margin-5">DENY</a>
                @endif
            </div>
        </div>
    </div>
</div>