<!DOCTYPE html>
<html>
<body>
<h1 class="text-center">{{date('F, Y', strtotime($report->report_date))}} Chapter Report
    for {{$report->chapter_info['chapter_name']}}</h1>
<hr>

COMMAND CREW INFORMATION<br>

COMMANDING OFFICER<br>
<br>
Name: {{$report->command_crew['CO']['first_name']}} @if(empty($report->command_crew['CO']->middile_name) === false) {{$report->command_crew['CO']['middle_name']}} @endif {{$report->command_crew['CO']['last_name']}} @if(empty($report->command_crew['CO']->suffix) === false) {{$report->command_crew['CO']->suffix}} @endif
<br>
SID#: {{$report->command_crew['CO']['member_id']}}<br>
Rank: {{$report->command_crew['CO']['rank']['grade']}}<br>
<br>
Last Course Completed: {{$report->command_crew['CO']['last_course']}}<br>
<br>
Date of Birth: {{date('m/d/Y', strtotime($report->command_crew['CO']['dob']))}}<br>
<br>
Phone:@if(empty($report->command_crew['CO']['phone_number']) === true)
    N/A @else {{$report->command_crew['CO']['phone_number']}} @endif <br>
Email: {{$report->command_crew['CO']['email_address']}}<br>
<br>
EXECUTIVE OFFICER<br>
<br>
Name: {{$report->command_crew['XO']['first_name']}} @if(empty($report->command_crew['XO']->middile_name) === false) {{$report->command_crew['XO']['middle_name']}} @endif {{$report->command_crew['XO']['last_name']}} @if(empty($report->command_crew['XO']->suffix) === false) {{$report->command_crew['XO']->suffix}} @endif
<br>
SID#: {{$report->command_crew['XO']['member_id']}}<br>
Rank: {{$report->command_crew['XO']['rank']['grade']}}<br>
<br>
Last Course Completed: {{$report->command_crew['XO']['last_course']}}<br>
<br>
Date of Birth: {{date('m/d/Y', strtotime($report->command_crew['XO']['dob']))}}<br>
<br>
Phone:@if(empty($report->command_crew['XO']['phone_number']) === true)
    N/A @else {{$report->command_crew['XO']['phone_number']}} @endif <br>
Email: {{$report->command_crew['XO']['email_address']}}<br>
<br>
CHIEF PETTY OFFICER<br>
<br>
Name: {{$report->command_crew['BOSUN']['first_name']}} @if(empty($report->command_crew['BOSUN']->middile_name) === false) {{$report->command_crew['BOSUN']['middle_name']}} @endif {{$report->command_crew['BOSUN']['last_name']}} @if(empty($report->command_crew['BOSUN']->suffix) === false) {{$report->command_crew['BOSUN']->suffix}} @endif
<br>
SID#: {{$report->command_crew['BOSUN']['member_id']}}<br>
Rank: {{$report->command_crew['BOSUN']['rank']['grade']}}<br>
<br>
Last Course Completed: {{$report->command_crew['BOSUN']['last_course']}}<br>
<br>
Date of Birth: {{date('m/d/Y', strtotime($report->command_crew['BOSUN']['dob']))}}<br>
<br>
Phone:@if(empty($report->command_crew['BOSUN']['phone_number']) === true)
    N/A @else {{$report->command_crew['BOSUN']['phone_number']}} @endif <br>
Email: {{$report->command_crew['BOSUN']['email_address']}}<br>
<br>
NEW REGULAR CREW SINCE LAST REPORT<br><br>


@if(count($report->new_crew) === 0)


    No new regular crew since last report<br>


@else
    @foreach($report->new_crew as $user)
        {{$user['member_id']}} {{$user['rank']['grade']}} {{ $user['first_name'] }}{{ isset($user['middle_name']) ? ' ' . $user['middle_name'] : '' }} {{ $user['last_name'] }}{{ !empty($user['suffix']) ? ' ' . $user['suffix'] : '' }}
        , {{$user['branch']}} <br>
    @endforeach
@endif


SHIP INFORMATION<br><br>
Class: @if(empty($report->chapter_info['ship_class']) === false) {{$report->chapter_info['ship_class']}} @endif <br>
Class Code: @if(empty($report->chapter_info['hull_number']) === false) {{$report->chapter_info['hull_number']}} @endif
<br>
<br>
Ship Name: {{$report->chapter_info['chapter_name']}}<br>
<br>
Location: {{$report->command_crew['CO']['city']}}, {{$report->command_crew['CO']['state_province']}}<br>
@if(empty($report->chapter_info['url']) === false)
    <br>Web Site: {{$report->chapter_info['url']}} <br>
@endif
<br>
REPORT INFORMATION<br><br>
Promotions Awarded/Requested: @if(empty($report->promotion_actions) === false) {{$report->promotion_actions}} @endif<br><br>
Awards Given/Requested: @if(empty($report->award_actions) === false) {{$report->award_actions}} @endif<br><br>
Courses Completed: @if(empty($report->courses) === false) {{$report->courses}} @endif<br><br>
Chapter Activites, Last 60 Days: @if(empty($report->activities) === false) {{$report->activities}} @endif<br><br>
Problems: @if(empty($report->problems) === false) {{$report->problems}} @endif<br><br>
General Questions: @if(empty($report->questions) === false) {{$report->questions}} @endif


</body>