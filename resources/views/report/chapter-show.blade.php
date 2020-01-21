@extends('layout')

@section('pageTitle')
    {!!date('F, Y', strtotime($report->report_date))!!} Chapter Report
    for {!!$report->chapter_info['chapter_name']!!}
@stop

@section('content')
    <h1 class="text-center">{!!date('F, Y', strtotime($report->report_date))!!} Chapter Report
        for {!!$report->chapter_info['chapter_name']!!}</h1>
    <hr>

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
            <br>BOSUN<br><br>
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
    @if(empty($report->new_crew))
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
            {!!$report->command_crew['Commanding Officer']['city']!!}
            , {!!$report->command_crew['Commanding Officer']['state_province']!!}
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
            @if(empty($report->promotion_actions) === false)
                {!!nl2br($report->promotion_actions)!!}
            @endif
        </div>
    </div>
    <br/>
    <div class="row">
        <div class=" col-sm-3">
            Crew Accomplishments:
        </div>
        <div class=" col-sm-9">
            @if(empty($report->award_actions) === false)
                {!!nl2br($report->award_actions)!!}
            @endif
        </div>
    </div>
    <br/>
    <div class="row">
        <div class=" col-sm-3">
            Courses Completed:
        </div>
        <div class=" col-sm-9">
            @if(empty($report->courses) === false)
                {!!nl2br($report->courses)!!}
            @endif
        </div>
    </div>
    <br/>
    <div class="row">
        <div class=" col-sm-3">
            Chapter Activities, Last 60 Days:
        </div>
        <div class=" col-sm-9">
            @if(empty($report->activities) === false)
                {!!nl2br($report->activities)!!}
            @endif
        </div>
    </div>
    <br/>
    <div class="row">
        <div class=" col-sm-3">
            Problems:
        </div>
        <div class=" col-sm-9">
            @if(empty($report->problems) === false)
                {!!nl2br($report->problems)!!}
            @endif
        </div>
    </div>
    <br/>
    <div class="row">
        <div class=" col-sm-3">
            General Questions:
        </div>
        <div class=" col-sm-9">
            @if(empty($report->questions) === false)
                {!!nl2br($report->questions)!!}
            @endif
        </div>
    </div>
    <br>
    <div class="text-center button-bar">
        <a href="{!! URL::previous() !!}" class="btn btn-primary"><span class="fa fa-backward"></span> Back </a>
        @if(empty($report['report_sent']) === true)
            &nbsp;<a href="{!!route('report.edit', $report->id)!!}" class="btn btn-success"><span
                        class="fa fa-edit"></span> Edit </a>
        @endif
    </div>
@stop
