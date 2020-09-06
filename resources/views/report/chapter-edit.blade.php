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
        <div class=" col-sm-12 small-text-center black-text reportSubHeader">
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
        <div class=" col-sm-12 small-text-center black-text reportSubHeader">
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
        <div class=" col-sm-12 small-text-center black-text reportSubHeader">
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
    <div class="row form-group">
        <div class=" col-sm-3">
            Promotions Awarded/Requested:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('promotion_actions', $report->promotion_actions, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Crew Accomplishments:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('award_actions', $report->award_actions, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            {!!Form::hidden('chapter_id',$report->chapter_id, ['id' => 'chapter_id'])!!}
            <a href="#" data-toggle="tooltip" class="fa fa-refresh green size-21" id="refreshExamList"
               title="Refresh Course List"></a>&nbsp;Courses Completed:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('courses', $report->courses, ['id' => 'courses', 'class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Chapter Activities, Last 60 Days:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('activities', $report->activities, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Problems:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('problems', $report->problems, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            General Questions:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('questions', $report->questions, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="text-center button-bar">
        <a href="{!! URL::previous() !!}" class="btn btn-warning"><span class="fa fa-times"></span> Cancel </a>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
        <button type="submit" class="btn btn-primary" name="send_report" value="send_report"
                onclick="return ConfirmSend()"><span class="fa fa-envelope"></span> Send
        </button>
    </div>


    {!!Form::close()!!}

    <div id="examList" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-title">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="text-center">Current Completed Exams</h4>
                </div>
                <div class="modal-body">
                    <p>You may copy and paste select elements from this or click the 'Append to Report' button to add it
                        to the end
                        of what is already in the input box.</p>

                    <div class="row">
                        <div>
                            {!!Form::textarea('results', null, ['id' => 'results', 'disabled' => '', 'class' => 'black-text'])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="button" id="copyExams">Append to Report</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scriptFooter')
    <script>
        function ConfirmSend() {
            return confirm('Click Ok to send the {!!date('F, Y', strtotime($report->report_date))!!} Chapter Report');
        }
    </script>
@stop