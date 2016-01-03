@extends('layout')

@section('pageTitle')
    {{$month}} Chapter Report for {{$chapter->chapter_name}}
@stop

@section('content')
    <h1 class="text-center">{{$month}} Chapter Report for {{$chapter->chapter_name}}</h1>
    <hr>

    {{Form::open([ 'route' => [ 'report.store' ]])}}
    {{Form::hidden('chapter_id', $chapter->_id)}}
    {{Form::hidden('report_date', date('Y-m', strtotime($month)))}}
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
            {{$command['CO']->first_name}} @if(empty($command['CO']->middile_name) === false) {{$command['CO']->middle_name}} @endif {{$command['CO']->last_name}} @if(empty($command['CO']->suffix) === false) {{$command['CO']->suffix}} @endif
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            SID#:
        </div>
        <div class="columns small-9">
            {{$command['CO']->member_id}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Rank:
        </div>
        <div class="columns small-9">
            {{$command['CO']->rank['grade']}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Last Course Completed:
        </div>
        <div class="columns small-3">
            {{$command['CO']->getHighestMainLineExamForBranch('officer+flag')}}
        </div>
        <div class="columns small-2 my">
            Date of Birth:
        </div>
        <div class="columns small-4">
            {{date('m/d/Y', strtotime($command['CO']->dob))}}
        </div>
    </div>

    <div class="row">
        <div class="columns small-3 my">
            Phone:
        </div>
        <div class="columns small-9">
            @if(empty($command['CO']) === true)N/A @else {{$command['CO']->phone_number}} @endif
        </div>
    </div>

    <div class="row">
        <div class="small-3 columns my">
            Email:
        </div>
        <div class="columns small-9">
            {{$command['CO']->email_address}}
        </div>
    </div>
    <br>

    <div class="row">
        <div class="columns small-12 small-text-center my reportSubHeader">
            <br>EXECUTIVE OFFICER<br><br>
        </div>
    </div>
    <br>
    @if(empty($command['XO']) === false)
        <div class="row">
            <div class="columns small-3 my">
                Name:
            </div>
            <div class="columns small-9">
                {{$command['XO']->first_name}} @if(empty($command['XO']->middile_name) === false) {{$command['XO']->middle_name}} @endif {{$command['XO']->last_name}} @if(empty($command['XO']->suffix) === false) {{$command['XO']->suffix}} @endif
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                SID#:
            </div>
            <div class="columns small-9">
                {{$command['XO']->member_id}}
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                Rank:
            </div>
            <div class="columns small-9">
                {{$command['XO']->rank['grade']}}
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                Last Course Completed:
            </div>
            <div class="columns small-3">
                {{$command['XO']->getHighestMainLineExamForBranch('officer+flag')}}
            </div>
            <div class="columns small-2 my">
                Date of Birth:
            </div>
            <div class="columns small-4">
                {{date('m/d/Y', strtotime($command['XO']->dob))}}
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                Phone:
            </div>
            <div class="columns small-9">
                @if(empty($command['XO']) === true)N/A @else {{$command['XO']->phone_number}} @endif
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns my">
                Email:
            </div>
            <div class="columns small-9">
                {{$command['XO']->email_address}}
            </div>
        </div>
    @else
        <div class="row">
            <div class="columns small-12 small-text-center my">None Found</div>
        </div>
    @endif
    <br>



    <div class="row">
        <div class="columns small-12 small-text-center my reportSubHeader">
            <br>CHIEF PETTY OFFICER<br><br>
        </div>
    </div>
    <br>
    @if(empty($command['BOSUN']) === false)
        <div class="row">
            <div class="columns small-3 my">
                Name:
            </div>
            <div class="columns small-9">
                {{$command['BOSUN']->first_name}} @if(empty($command['BOSUN']->middile_name) === false) {{$command['BOSUN']->middle_name}} @endif {{$command['BOSUN']->last_name}} @if(empty($command['BOSUN']->suffix) === false) {{$command['BOSUN']->suffix}} @endif
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                SID#:
            </div>
            <div class="columns small-9">
                {{$command['BOSUN']->member_id}}
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                Rank:
            </div>
            <div class="columns small-9">
                {{$command['BOSUN']->rank['grade']}}
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                Last Course Completed:
            </div>
            <div class="columns small-3">
                {{$command['BOSUN']->getHighestMainLineExamForBranch('enlisted')}}
            </div>
            <div class="columns small-2 my">
                Date of Birth:
            </div>
            <div class="columns small-4">
                {{date('m/d/Y', strtotime($command['BOSUN']->dob))}}
            </div>
        </div>

        <div class="row">
            <div class="columns small-3 my">
                Phone:
            </div>
            <div class="columns small-9">
                @if(empty($command['BOSUN']) === true)N/A @else {{$command['BOSUN']->phone_number}} @endif
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns my">
                Email:
            </div>
            <div class="columns small-9">
                {{$command['BOSUN']->email_address}}
            </div>
        </div>
    @else
        <div class="row">
            <div class="columns small-12 small-text-center my">None Found</div>
        </div>
    @endif
    <br>

    <div class="row">
        <div class="columns small-12 small-text-center my reportHeader">
            <br>NEW REGULAR CREW SINCE LAST REPORT<br><br>
        </div>
    </div>
    <br>
    @if(count($newCrew) === 0)
        <div class="row">
            <div class="columns small-text-center small-12">
                No new regular crew since last report
            </div>
        </div>
    @else
        @foreach($newCrew as $user)
            <div class="row">
                <row class="columns small-1">
                    {{$user['rank']['grade']}}
                </row>
                <div class="columns small-4">
                    {{ $user['first_name'] }}{{ isset($user['middle_name']) ? ' ' . $user['middle_name'] : '' }} {{ $user['last_name'] }}{{ !empty($user['suffix']) ? ' ' . $user['suffix'] : '' }}
                    {{!empty($user['branch']) ? ', ' . $user['branch'] : ''}}
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
            @if(empty($chapter->ship_class) === false)
                {{$chapter->ship_class}}
            @else
                N/A
            @endif
        </div>
        <div class="columns small-2">
            Class Code:
        </div>
        <div class="columns small-4">
            @if(empty($chapter->hull_number) === false)
                {{$chapter->hull_number}}
            @else
                N/A
            @endif
        </div>
    </div>

    <div class="row">
        <div class="columns small-2">
            Ship Name:
        </div>
        <div class="columns small-4">
            {{$chapter->chapter_name}}
        </div>
        <div class="columns small-2">
            Location:
        </div>
        <div class="columns small-4">
            {{$command['CO']->city}}, {{$command['CO']->state_province}}
        </div>
    </div>

    @if(empty($chapter->url) === false)
        <div class="row">
            <div class="columns small-2">
                Web Site:
            </div>
            <div class="columns small-10">
                {{$chapter->url}}
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
            Courses Completed:
        </div>
        <div class="columns small-9">
            {{Form::textarea('courses', $completed)}}
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
@stop
