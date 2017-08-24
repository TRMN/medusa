@extends('layout')

@section('pageTitle')
    {!!date('F, Y', strtotime($report->report_date))!!} Chapter Report
    for {!!$report->chapter_info['chapter_name']!!}
@stop

@section('content')
    <h1 class="text-center">{!!date('F, Y', strtotime($report->report_date))!!} Chapter Report
        for {!!$report->chapter_info['chapter_name']!!}</h1>
    <hr>

    {!!Form::model($report, [ 'route' => [ 'report.update', $report->id ], 'method' => 'put'])!!}

    <div class="row">
        <div class=" col-sm-12 small-text-center my reportHeader">
            <br>COMMAND CREW INFORMATION<br><br>
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-12 small-text-center my reportSubHeader">
            <br>COMMANDING OFFICER<br><br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class=" col-sm-3 my">
            Name:
        </div>
        <div class=" col-sm-9">
            {!!$report->command_crew['Commanding Officer']['first_name']!!} @if(empty($report->command_crew['Commanding Officer']->middile_name) === false) {!!$report->command_crew['Commanding Officer']['middle_name']!!} @endif {!!$report->command_crew['Commanding Officer']['last_name']!!} @if(empty($report->command_crew['Commanding Officer']->suffix) === false) {!!$report->command_crew['Commanding Officer']->suffix!!} @endif
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            SID#:
        </div>
        <div class=" col-sm-9">
            {!!$report->command_crew['Commanding Officer']['member_id']!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            Rank:
        </div>
        <div class=" col-sm-9">
            {!!$report->command_crew['Commanding Officer']['rank']['grade']!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            Last Course Completed:
        </div>
        <div class=" col-sm-3">
            {!!$report->command_crew['Commanding Officer']['last_course']!!}
        </div>
        <div class=" col-sm-2 my">
            Date of Birth:
        </div>
        <div class=" col-sm-4">
            {!!date('m/d/Y', strtotime($report->command_crew['Commanding Officer']['dob']))!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            Phone:
        </div>
        <div class=" col-sm-9">
            @if(empty($report->command_crew['Commanding Officer']['phone_number']) === true)
                N/A @else {!!$report->command_crew['Commanding Officer']['phone_number']!!} @endif
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3  my">
            Email:
        </div>
        <div class=" col-sm-9">
            {!!$report->command_crew['Commanding Officer']['email_address']!!}
        </div>
    </div>
    <br>
    <div class="row">
        <div class=" col-sm-12 small-text-center my reportSubHeader">
            <br>EXECUTIVE OFFICER<br><br>
        </div>
    </div>
    <br>
    @if(empty($report->command_crew['Executive Officer']) === false)
        <div class="row">
            <div class=" col-sm-3 my">
                Name:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Executive Officer']['first_name']!!} @if(empty($report->command_crew['Executive Officer']->middile_name) === false) {!!$report->command_crew['Executive Officer']['middle_name']!!} @endif {!!$report->command_crew['Executive Officer']['last_name']!!} @if(empty($report->command_crew['Executive Officer']->suffix) === false) {!!$report->command_crew['Executive Officer']->suffix!!} @endif
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                SID#:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Executive Officer']['member_id']!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Rank:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Executive Officer']['rank']['grade']!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Last Course Completed:
            </div>
            <div class=" col-sm-3">
                {!!$report->command_crew['Executive Officer']['last_course']!!}
            </div>
            <div class=" col-sm-2 my">
                Date of Birth:
            </div>
            <div class=" col-sm-4">
                {!!date('m/d/Y', strtotime($report->command_crew['Executive Officer']['dob']))!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Phone:
            </div>
            <div class=" col-sm-9">
                @if(empty($report->command_crew['Executive Officer']['phone_number']) === true)
                    N/A @else {!!$report->command_crew['Executive Officer']['phone_number']!!} @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3  my">
                Email:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Executive Officer']['email_address']!!}
            </div>
        </div>
    @else
        <div class="row">
            <div class=" col-sm-12 small-text-center my">None Found</div>
        </div>
    @endif

    <br>
    <div class="row">
        <div class=" col-sm-12 small-text-center my reportSubHeader">
            <br>CHIEF PETTY OFFICER<br><br>
        </div>
    </div>
    <br>
    @if(empty($report->command_crew['Bosun']) === false)
        <div class="row">
            <div class=" col-sm-3 my">
                Name:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Bosun']['first_name']!!} @if(empty($report->command_crew['Bosun']->middile_name) === false) {!!$report->command_crew['Bosun']['middle_name']!!} @endif {!!$report->command_crew['Bosun']['last_name']!!} @if(empty($report->command_crew['Bosun']->suffix) === false) {!!$report->command_crew['Bosun']->suffix!!} @endif
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                SID#:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Bosun']['member_id']!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Rank:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Bosun']['rank']['grade']!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Last Course Completed:
            </div>
            <div class=" col-sm-3">
                {!!$report->command_crew['Bosun']['last_course']!!}
            </div>
            <div class=" col-sm-2 my">
                Date of Birth:
            </div>
            <div class=" col-sm-4">
                {!!date('m/d/Y', strtotime($report->command_crew['Bosun']['dob']))!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Phone:
            </div>
            <div class=" col-sm-9">
                @if(empty($report->command_crew['Bosun']['phone_number']) === true)
                    N/A @else {!!$report->command_crew['Bosun']['phone_number']!!} @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3  my">
                Email:
            </div>
            <div class=" col-sm-9">
                {!!$report->command_crew['Bosun']['email_address']!!}
            </div>
        </div>
    @else
        <div class="row">
            <div class=" col-sm-12 small-text-center my">None Found</div>
        </div>
    @endif
    <br>

    <div class="row">
        <div class=" col-sm-12 small-text-center my reportHeader">
            <br>NEW REGULAR CREW SINCE LAST REPORT<br><br>
        </div>
    </div>
    <br>
    @if(count($report->new_crew) === 0)
        <div class="row">
            <div class=" small-text-center col-sm-12">
                No new regular crew since last report
            </div>
        </div>
    @else
        @foreach($report->new_crew as $user)
            <div class="row">
                <row class=" col-sm-1">
                    {!!$user['rank']['grade']!!}
                </row>
                <div class=" col-sm-4">
                    {!! $user['first_name'] !!}{{ isset($user['middle_name']) ? ' ' . $user['middle_name'] : '' }} {!! $user['last_name'] !!}{{ !empty($user['suffix']) ? ' ' . $user['suffix'] : '' }}
                    , {!!$user['branch']!!}
                </div>
                <div class=" col-sm-3 ">
                    {!!$user['member_id']!!}
                </div>
            </div>
        @endforeach
    @endif

    <br>

    <div class="row">
        <div class=" col-sm-12 small-text-center my reportHeader">
            <br>SHIP INFORMATION<br><br>
        </div>
    </div>
    <br>

    <div class="row">
        <div class=" col-sm-2">
            Class:
        </div>
        <div class=" col-sm-4">
            @if(empty($report->chapter_info['ship_class']) === false)
                {!!$report->chapter_info['ship_class']!!}
            @endif
        </div>
        <div class=" col-sm-2">
            Class Code:
        </div>
        <div class=" col-sm-4">
            @if(empty($report->chapter_info['hull_number']) === false)
                {!!$report->chapter_info['hull_number']!!}
            @endif
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-2">
            Ship Name:
        </div>
        <div class=" col-sm-4">
            {!!$report->chapter_info['chapter_name']!!}
        </div>
        <div class=" col-sm-2">
            Location:
        </div>
        <div class=" col-sm-4">
            {!!$report->command_crew['Commanding Officer']['city']!!}, {!!$report->command_crew['Commanding Officer']['state_province']!!}
        </div>
    </div>

    @if(empty($report->chapter_info['url']) === false)
        <div class="row">
            <div class=" col-sm-2">
                Web Site:
            </div>
            <div class=" col-sm-10">
                {!!$report->chapter_info['url']!!}
            </div>
        </div>
    @endif

    <br>

    <div class="row">
        <div class=" col-sm-12 small-text-center my reportHeader">
            <br>REPORT INFORMATION<br><br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class=" col-sm-3">
            Promotions Awarded/Requested:
        </div>
        <div class=" col-sm-9">
            {!!Form::text('promotion_actions')!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3">
            Awards Given/Requested:
        </div>
        <div class=" col-sm-9">
            {!!Form::text('award_actions')!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3">
            {!!Form::hidden('chapter_id',$report->chapter_id, ['id' => 'chapter_id'])!!}
            <a href="#" data-reveal-id="examList" class="fa fa-refresh green size-21" id="refreshExamList"
               data-toggle="tooltip" title="Refresh Course List"></a> Courses Completed:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('courses', $report->courses, ['id' => 'courses'])!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3">
            Chapter Activites, Last 60 Days:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('activities')!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3">
            Problems:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('problems')!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3">
            General Questions:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('questions')!!}
        </div>
    </div>

    <div class="text-center button-bar">
        <a href="{!! URL::previous() !!}" class="btn round"> Cancel </a>&nbsp;
        {!! Form::submit('Save', [ 'class' => 'btn round' ] ) !!}&nbsp;
        {!! Form::submit('Send', [ 'class' => 'btn round', 'name' => 'send_report']) !!}
    </div>


    {!!Form::close()!!}

    <div id="examList" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h4 class="text-center">Current Completed Exams</h4>

        <p>You may copy and paste select elements from this or click the 'Append to Report' button to add it to the end
            of what is already in the input box.</p>

        <div class="row">
            <div>
                {!!Form::textarea('results', null, ['id' => 'results', 'disabled'])!!}
            </div>
        </div>
        <div class="row">
            <button class="btn round" id="copyExams">Append to Report</button>
        </div>

        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

@stop
