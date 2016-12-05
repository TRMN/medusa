<!DOCTYPE html>
<html>
<body>
<h1 class="text-center">{!!date('F, Y', strtotime($report->report_date))!!} Chapter Report
    for {!!$report->chapter_info['chapter_name']!!}</h1>
<hr>

COMMAND CREW INFORMATION<br>

COMMANDING OFFICER<br>
<br>
Name: {!!$report->command_crew['Commanding Officer']['first_name']!!} @if(empty($report->command_crew['Commanding Officer']->middile_name) === false) {!!$report->command_crew['Commanding Officer']['middle_name']!!} @endif {!!$report->command_crew['Commanding Officer']['last_name']!!} @if(empty($report->command_crew['Commanding Officer']->suffix) === false) {!!$report->command_crew['Commanding Officer']->suffix!!} @endif
<br>
SID#: {!!$report->command_crew['Commanding Officer']['member_id']!!}<br>
Rank: {!!$report->command_crew['Commanding Officer']['rank']['grade']!!}<br>
<br>
Last Course Completed: {!!$report->command_crew['Commanding Officer']['last_course']!!}<br>
<br>
Date of Birth: {!!date('m/d/Y', strtotime($report->command_crew['Commanding Officer']['dob']))!!}<br>
<br>
Phone:@if(empty($report->command_crew['Commanding Officer']['phone_number']) === true)
    N/A @else {!!$report->command_crew['Commanding Officer']['phone_number']!!} @endif <br>
Email: {!!$report->command_crew['Commanding Officer']['email_address']!!}<br>
<br>

EXECUTIVE OFFICER<br>
<br>
@if(empty($report->command_crew['Executive Officer']) === false)
Name: {!!$report->command_crew['Executive Officer']['first_name']!!} @if(empty($report->command_crew['Executive Officer']->middile_name) === false) {!!$report->command_crew['Executive Officer']['middle_name']!!} @endif {!!$report->command_crew['Executive Officer']['last_name']!!} @if(empty($report->command_crew['Executive Officer']->suffix) === false) {!!$report->command_crew['Executive Officer']->suffix!!} @endif
<br>
SID#: {!!$report->command_crew['Executive Officer']['member_id']!!}<br>
Rank: {!!$report->command_crew['Executive Officer']['rank']['grade']!!}<br>
<br>
Last Course Completed: {!!$report->command_crew['Executive Officer']['last_course']!!}<br>
<br>
Date of Birth: {!!date('m/d/Y', strtotime($report->command_crew['Executive Officer']['dob']))!!}<br>
<br>
Phone:@if(empty($report->command_crew['Executive Officer']['phone_number']) === true)
    N/A @else {!!$report->command_crew['Executive Officer']['phone_number']!!} @endif <br>
Email: {!!$report->command_crew['Executive Officer']['email_address']!!}<br>
@else
None Found
@endif
<br>


CHIEF PETTY OFFICER<br>
<br>
@if(empty($report->command_crew['Bosun']) === false)
Name: {!!$report->command_crew['Bosun']['first_name']!!} @if(empty($report->command_crew['Bosun']->middile_name) === false) {!!$report->command_crew['Bosun']['middle_name']!!} @endif {!!$report->command_crew['Bosun']['last_name']!!} @if(empty($report->command_crew['Bosun']->suffix) === false) {!!$report->command_crew['Bosun']->suffix!!} @endif
<br>
SID#: {!!$report->command_crew['Bosun']['member_id']!!}<br>
Rank: {!!$report->command_crew['Bosun']['rank']['grade']!!}<br>
<br>
Last Course Completed: {!!$report->command_crew['Bosun']['last_course']!!}<br>
<br>
Date of Birth: {!!date('m/d/Y', strtotime($report->command_crew['Bosun']['dob']))!!}<br>
<br>
Phone:@if(empty($report->command_crew['Bosun']['phone_number']) === true)
    N/A @else {!!$report->command_crew['Bosun']['phone_number']!!} @endif <br>
Email: {!!$report->command_crew['Bosun']['email_address']!!}<br>
@else
None Found
@endif
<br>

NEW REGULAR CREW SINCE LAST REPORT<br><br>


@if(count($report->new_crew) === 0)


    No new regular crew since last report<br>


@else
    @foreach($report->new_crew as $user)
        {!!$user['member_id']!!} {!!$user['rank']['grade']!!} {!! $user['first_name'] !!}{{ isset($user['middle_name']) ? ' ' . $user['middle_name'] : '' }} {!! $user['last_name'] !!}{{ !empty($user['suffix']) ? ' ' . $user['suffix'] : '' }}
        , {!!$user['branch']!!} <br>
    @endforeach
@endif


SHIP INFORMATION<br><br>
Class: @if(empty($report->chapter_info['ship_class']) === false) {!!$report->chapter_info['ship_class']!!} @else N/A @endif <br>
Class Code: @if(empty($report->chapter_info['hull_number']) === false) {!!$report->chapter_info['hull_number']!!} @else N/A @endif
<br>
<br>
Ship Name: {!!$report->chapter_info['chapter_name']!!}<br>
<br>
Location: {!!$report->command_crew['Commanding Officer']['city']!!}, {!!$report->command_crew['Commanding Officer']['state_province']!!}<br>
@if(empty($report->chapter_info['url']) === false)
    <br>Web Site: {!!$report->chapter_info['url']!!} <br>
@endif
<br>
REPORT INFORMATION<br><br>
Promotions Awarded/Requested: @if(empty($report->promotion_actions) === false) {!!$report->promotion_actions!!} @endif<br><br>
Awards Given/Requested: @if(empty($report->award_actions) === false) {!!$report->award_actions!!} @endif<br><br>
Courses Completed: @if(empty($report->courses) === false) {!!$report->courses!!} @endif<br><br>
Chapter Activites, Last 60 Days: @if(empty($report->activities) === false) {!!$report->activities!!} @endif<br><br>
Problems: @if(empty($report->problems) === false) {!!$report->problems!!} @endif<br><br>
General Questions: @if(empty($report->questions) === false) {!!$report->questions!!} @endif


</body>