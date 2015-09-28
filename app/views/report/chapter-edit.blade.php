@extends('layout')

@section('pageTitle')
    {{date('F, Y', strtotime($report->report_date))}} Chapter Report
        for {{$report->chapter_info['chapter_name']}}
@stop

@section('content')
    <h1 class="text-center">{{date('F, Y', strtotime($report->report_date))}} Chapter Report for {{$report->chapter_info['chapter_name']}}</h1>
    <hr>

    {{Form::model($report, [ 'route' => [ 'report.update', $report->id ], 'method' => 'put'])}}

    <div class="row">
        <div class="columns small-12 small-text-center my reportHeader">
            <br>COMMAND CREW INFORMATION<br><br>
        </div>
    </div>

    <div class="row">
        <div class="columns small-12 small-text-center my reportSubHeader">
            <br>COMMANDING OFFICER<br><br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="columns small-3 my">
            Name:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['CO']['first_name']}} @if(empty($report->command_crew['CO']->middile_name) === false) {{$report->command_crew['CO']['middle_name']}} @endif {{$report->command_crew['CO']['last_name']}} @if(empty($report->command_crew['CO']->suffix) === false) {{$report->command_crew['CO']->suffix}} @endif
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            SID#:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['CO']['member_id']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Rank:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['CO']['rank']['grade']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Last Course Completed:
        </div>
        <div class="columns small-3">
            {{$report->command_crew['CO']['last_course']}}
        </div>
        <div class="columns small-2 my">
            Date of Birth:
        </div>
        <div class="columns small-4">
            {{date('m/d/Y', strtotime($report->command_crew['CO']['dob']))}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Phone:
        </div>
        <div class="columns small-9">
            @if(empty($report->command_crew['CO']['phone_number']) === true)N/A @else {{$report->command_crew['CO']['phone_number']}} @endif
        </div>
    </div>

    <div class="row">
        <div class="small-3 columns my">
            Email:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['CO']['email_address']}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="columns small-12 small-text-center my reportSubHeader">
            <br>EXECUTIVE OFFICER<br><br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="columns small-3 my">
            Name:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['XO']['first_name']}} @if(empty($report->command_crew['XO']->middile_name) === false) {{$report->command_crew['XO']['middle_name']}} @endif {{$report->command_crew['XO']['last_name']}} @if(empty($report->command_crew['XO']->suffix) === false) {{$report->command_crew['XO']->suffix}} @endif
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            SID#:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['XO']['member_id']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Rank:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['XO']['rank']['grade']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Last Course Completed:
        </div>
        <div class="columns small-3">
            {{$report->command_crew['XO']['last_course']}}
        </div>
        <div class="columns small-2 my">
            Date of Birth:
        </div>
        <div class="columns small-4">
            {{date('m/d/Y', strtotime($report->command_crew['XO']['dob']))}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Phone:
        </div>
        <div class="columns small-9">
            @if(empty($report->command_crew['XO']['phone_number']) === true)N/A @else {{$report->command_crew['XO']['phone_number']}} @endif
        </div>
    </div>

    <div class="row">
        <div class="small-3 columns my">
            Email:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['XO']['email_address']}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="columns small-12 small-text-center my reportSubHeader">
            <br>CHIEF PETTY OFFICER<br><br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="columns small-3 my">
            Name:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['BOSUN']['first_name']}} @if(empty($report->command_crew['BOSUN']->middile_name) === false) {{$report->command_crew['BOSUN']['middle_name']}} @endif {{$report->command_crew['BOSUN']['last_name']}} @if(empty($report->command_crew['BOSUN']->suffix) === false) {{$report->command_crew['BOSUN']->suffix}} @endif
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            SID#:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['BOSUN']['member_id']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Rank:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['BOSUN']['rank']['grade']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Last Course Completed:
        </div>
        <div class="columns small-3">
            {{$report->command_crew['BOSUN']['last_course']}}
        </div>
        <div class="columns small-2 my">
            Date of Birth:
        </div>
        <div class="columns small-4">
            {{date('m/d/Y', strtotime($report->command_crew['BOSUN']['dob']))}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Phone:
        </div>
        <div class="columns small-9">
            @if(empty($report->command_crew['BOSUN']['phone_number']) === true)N/A @else {{$report->command_crew['BOSUN']['phone_number']}} @endif
        </div>
    </div>

    <div class="row">
        <div class="small-3 columns my">
            Email:
        </div>
        <div class="columns small-9">
            {{$report->command_crew['BOSUN']['email_address']}}
        </div>
    </div>

    <br>

    <div class="row">
        <div class="columns small-12 small-text-center my reportHeader">
            <br>NEW REGULAR CREW SINCE LAST REPORT<br><br>
        </div>
    </div>
    <br>
    @if(count($report->new_crew) === 0)
        <div class="row">
            <div class="columns small-text-center small-12">
                No new regular crew since last report
            </div>
        </div>
    @else
        @foreach($report->new_crew as $user)
            <div class="row">
                <row class="columns small-1">
                    {{$user['rank']['grade']}}
                </row>
                <div class="columns small-4">
                    {{ $user['first_name'] }}{{ isset($user['middle_name']) ? ' ' . $user['middle_name'] : '' }} {{ $user['last_name'] }}{{ !empty($user['suffix']) ? ' ' . $user['suffix'] : '' }}
                    , {{$user['branch']}}
                </div>
                <div class="columns small-3 end">
                    {{$user['member_id']}}
                </div>
            </div>
        @endforeach
    @endif

    <br>

    <div class="row">
        <div class="columns small-12 small-text-center my reportHeader">
            <br>SHIP INFORMATION<br><br>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="columns small-2">
            Class:
        </div>
        <div class="columns small-4">
            @if(empty($report->chapter_info['ship_class']) === false)
                {{$report->chapter_info['ship_class']}}
            @endif
        </div>
        <div class="columns small-2">
            Class Code:
        </div>
        <div class="columns small-4">
            @if(empty($report->chapter_info['hull_number']) === false)
                {{$report->chapter_info['hull_number']}}
            @endif
        </div>
    </div>

    <div class="row">
        <div class="columns small-2">
            Ship Name:
        </div>
        <div class="columns small-4">
            {{$report->chapter_info['chapter_name']}}
        </div>
        <div class="columns small-2">
            Location:
        </div>
        <div class="columns small-4">
            {{$report->command_crew['CO']['city']}}, {{$report->command_crew['CO']['state_province']}}
        </div>
    </div>

    @if(empty($report->chapter_info['url']) === false)
        <div class="row">
            <div class="columns small-2">
                Web Site:
            </div>
            <div class="columns small-10">
                {{$report->chapter_info['url']}}
            </div>
        </div>
    @endif

    <br>

    <div class="row">
        <div class="columns small-12 small-text-center my reportHeader">
            <br>REPORT INFORMATION<br><br>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="columns small-3">
            Promotions Awarded/Requested:
        </div>
        <div class="columns small-9">
            {{Form::text('promotion_actions')}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3">
            Awards Given/Requested:
        </div>
        <div class="columns small-9">
            {{Form::text('award_actions')}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3">
            {{Form::hidden('chapter_id',$report->chapter_id, ['id' => 'chapter_id'])}}
            <a href="#" data-reveal-id="examList" class="fi-refresh green size-21" id="refreshExamList" title="Refresh Course List"></a> Courses Completed:
        </div>
        <div class="columns small-9">
            {{Form::textarea('courses', $report->courses, ['id' => 'courses'])}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3">
            Chapter Activites, Last 60 Days:
        </div>
        <div class="columns small-9">
            {{Form::textarea('activities')}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3">
            Problems:
        </div>
        <div class="columns small-9">
            {{Form::textarea('problems')}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3">
            General Questions:
        </div>
        <div class="columns small-9">
            {{Form::textarea('questions')}}
        </div>
    </div>

    <div class="text-center button-bar">
        <a href="{{ URL::previous() }}" class="button round"> Cancel </a>&nbsp;
        {{ Form::submit('Save', [ 'class' => 'button round' ] ) }}&nbsp;
        {{ Form::submit('Send', [ 'class' => 'button round', 'name' => 'send_report']) }}
    </div>


    {{Form::close()}}

    <div id="examList" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h4 class="text-center">Current Completed Exams</h4>
        <p>You may copy and paste select elements from this or click the 'Append to Report' button to add it to the end
        of what is already in the input box.</p>
        <div class="row">
           <div>
                {{Form::textarea('results', null, ['id' => 'results', 'disabled'])}}
           </div>
        </div>
        <div class="row">
            <button class="button round" id="copyExams">Append to Report</button>
        </div>

        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

@stop
