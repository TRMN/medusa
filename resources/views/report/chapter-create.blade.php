@extends('layout')

@section('pageTitle')
    {!!$month!!} Chapter Report for {!!$chapter->chapter_name!!}
@stop

@section('content')
    <h1 class="text-center">{!!$month!!} Chapter Report for {!!$chapter->chapter_name!!}</h1>
    <hr>

    {!!Form::open([ 'route' => [ 'report.store' ]])!!}
    {!!Form::hidden('chapter_id', $chapter->_id)!!}
    {!!Form::hidden('report_date', date('Y-m', strtotime($month)))!!}
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
            {!!$command[1]['user']->first_name!!} @if(empty($command[1]['user']->middile_name) === false) {!!$command[1]['user']->middle_name!!} @endif {!!$command[1]['user']->last_name!!} @if(empty($command[1]['user']->suffix) === false) {!!$command[1]['user']->suffix!!} @endif
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            SID#:
        </div>
        <div class=" col-sm-9">
            {!!$command[1]['user']->member_id!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            Rank:
        </div>
        <div class=" col-sm-9">
            {!!$command[1]['user']->rank['grade']!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            Last Course Completed:
        </div>
        <div class=" col-sm-3">
            {!!$command[1]['user']->getHighestMainLineExamForBranch('officer+flag')!!}
        </div>
        <div class=" col-sm-2 my">
            Date of Birth:
        </div>
        <div class=" col-sm-4">
            {!!date('m/d/Y', strtotime($command[1]['user']->dob))!!}
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-3 my">
            Phone:
        </div>
        <div class=" col-sm-9">
            @if(empty($command[1]['user']) === true)N/A @else {!!$command[1]['user']->phone_number!!} @endif
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3  my">
            Email:
        </div>
        <div class=" col-sm-9">
            {!!$command[1]['user']->email_address!!}
        </div>
    </div>
    <br>

    <div class="row">
        <div class=" col-sm-12 small-text-center black-text reportSubHeader">
            <br>EXECUTIVE OFFICER<br><br>
        </div>
    </div>
    <br>
    @if(empty($command[2]['user']) === false)
        <div class="row">
            <div class=" col-sm-3 my">
                Name:
            </div>
            <div class=" col-sm-9">
                {!!$command[2]['user']->first_name!!} @if(empty($command[2]['user']->middile_name) === false) {!!$command[2]['user']->middle_name!!} @endif {!!$command[2]['user']->last_name!!} @if(empty($command[2]['user']->suffix) === false) {!!$command[2]['user']->suffix!!} @endif
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                SID#:
            </div>
            <div class=" col-sm-9">
                {!!$command[2]['user']->member_id!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Rank:
            </div>
            <div class=" col-sm-9">
                {!!$command[2]['user']->rank['grade']!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Last Course Completed:
            </div>
            <div class=" col-sm-3">
                {!!$command[2]['user']->getHighestMainLineExamForBranch('officer+flag')!!}
            </div>
            <div class=" col-sm-2 my">
                Date of Birth:
            </div>
            <div class=" col-sm-4">
                {!!date('m/d/Y', strtotime($command[2]['user']->dob))!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Phone:
            </div>
            <div class=" col-sm-9">
                @if(empty($command[2]['user']) === true)N/A @else {!!$command[2]['user']->phone_number!!} @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3  my">
                Email:
            </div>
            <div class=" col-sm-9">
                {!!$command[2]['user']->email_address!!}
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
    @if(empty($command[3]['user']) === false)
        <div class="row">
            <div class=" col-sm-3 my">
                Name:
            </div>
            <div class=" col-sm-9">
                {!!$command[3]['user']->first_name!!} @if(empty($command[3]['user']->middile_name) === false) {!!$command[3]['user']->middle_name!!} @endif {!!$command[3]['user']->last_name!!} @if(empty($command[3]['user']->suffix) === false) {!!$command[3]['user']->suffix!!} @endif
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                SID#:
            </div>
            <div class=" col-sm-9">
                {!!$command[3]['user']->member_id!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Rank:
            </div>
            <div class=" col-sm-9">
                {!!$command[3]['user']->rank['grade']!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Last Course Completed:
            </div>
            <div class=" col-sm-3">
                {!!$command[3]['user']->getHighestMainLineExamForBranch('enlisted')!!}
            </div>
            <div class=" col-sm-2 my">
                Date of Birth:
            </div>
            <div class=" col-sm-4">
                {!!date('m/d/Y', strtotime($command[3]['user']->dob))!!}
            </div>
        </div>

        <div class="row">
            <div class=" col-sm-3 my">
                Phone:
            </div>
            <div class=" col-sm-9">
                @if(empty($command[3]['user']) === true)N/A @else {!!$command[3]['user']->phone_number!!} @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3  my">
                Email:
            </div>
            <div class=" col-sm-9">
                {!!$command[3]['user']->email_address!!}
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
    @if(empty($newCrew))
        <div class="row">
            <div class=" small-text-center col-sm-12">
                No new regular crew since last report
            </div>
        </div>
    @else
        @foreach($newCrew as $user)
            <div class="row">
                <row class=" col-sm-1">
                    {!!$user['rank']['grade']!!}
                </row>
                <div class=" col-sm-4">
                    {!! $user['first_name'] !!}{{ isset($user['middle_name']) ? ' ' . $user['middle_name'] : '' }} {!! $user['last_name'] !!}{{ !empty($user['suffix']) ? ' ' . $user['suffix'] : '' }}
                    {!!!empty($user['branch']) ? ', ' . $user['branch'] : ''!!}
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
            @if(empty($chapter->ship_class) === false)
                {!!$chapter->ship_class!!}
            @else
                N/A
            @endif
        </div>
        <div class=" col-sm-2">
            Class Code:
        </div>
        <div class=" col-sm-4">
            @if(empty($chapter->hull_number) === false)
                {!!$chapter->hull_number!!}
            @else
                N/A
            @endif
        </div>
    </div>

    <div class="row">
        <div class=" col-sm-2">
            Ship Name:
        </div>
        <div class=" col-sm-4">
            {!!$chapter->chapter_name!!}
        </div>
        <div class=" col-sm-2">
            Location:
        </div>
        <div class=" col-sm-4">
            {!!$command[1]['user']->city!!}, {!!$command[1]['user']->state_province!!}
        </div>
    </div>

    @if(empty($chapter->url) === false)
        <div class="row">
            <div class=" col-sm-2">
                Web Site:
            </div>
            <div class=" col-sm-10">
                {!!$chapter->url!!}
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
            {!!Form::textarea('promotion_actions', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Awards Given/Requested:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('award_actions', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Courses Completed:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('courses', $completed, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Chapter Activities, Last 60 Days:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('activities', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            Problems:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('problems', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="row form-group">
        <div class=" col-sm-3">
            General Questions:
        </div>
        <div class=" col-sm-9">
            {!!Form::textarea('questions', null, ['class' => 'form-control'])!!}
        </div>
    </div>

    <div class="text-center button-bar">
        <a href="{!! URL::previous() !!}" class="btn btn-warning"><span class="fa fa-times"></span> Cancel </a>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>
        <button type="submit" class="btn btn-primary" name="send_report" value="send_report" onclick="return ConfirmSend()"><span class="fa fa-envelope"></span> Send </button>
    </div>


    {!!Form::close()!!}
@stop

@section('scriptFooter')
    <script>
        function ConfirmSend()
        {
            return confirm('Click Ok to send the {!!$month!!} Chapter Report');
        }
    </script>
@stop