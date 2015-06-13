@extends('layout')

@section('pageTitle')
    Service Record
@stop

@section('content')
    <h4 class="trmn my">Service Record</h4>
    <h5 class="Incised901Light seventy-five">Last Updated: {{{ date('d M Y @ g:i A T', strtotime($user->updated_at)) }}}</h5>

    <div id="user-profile">
        <div class="Incised901Bold">
            {{{ $user->getGreeting() }}} {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}{{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}}
        </div>
        <div class="NordItalic">{{{$user->getPrimaryAssignmentName()}}} {{{$user->getPrimaryAssignmentDesignation()}}}</div>
        <div class="Incised901Light filePhoto">
            {{{$user->member_id}}}
            <div class="filePhotoBox">
                <div class="ofpt">
                    Official<br/>File<br/>Photo
                </div>
            </div>
            {{{$user->getPrimaryBillet()}}}
        </div>
        <div class="Incised901Black seventy-five">
            Time In Grade:
        </div>
        <div class="Incised901Black seventy-five">
            Awards:
        </div>

        <div class="Incised901Black seventy-five">
            Academy Coursework:
            @foreach($user->getExamList() as $exam => $gradeInfo)
                <div class="row">
                    <div class="small-1 columns Incised901Light seventy-five">&nbsp;</div>
                    <div class="small-2 columns Incised901Light seventy-five textLeft">{{{$exam}}}</div>
                    <div class="small-2 columns Incised901Light seventy-five textRight">{{{$gradeInfo['score']}}}</div>
                    <div class="small-2 columns Incised901Light seventy-five end textRight">{{{$gradeInfo['date']}}}</div>
                </div>
            @endforeach
        </div>
        <div class="Incised901Black seventy-five">
            Contact:
            <div class="row">
                <div class="small-1 columns Incised901Light seventy-five">&nbsp;</div>
                <div class="small-10 columns Incised901Light seventy-five textLeft end">
                    {{{ $user->address_1 }}}<br />
                    {{ isset($user->address_2)? $user->address_2 . '<br />': ''}}
                    {{{ $user->city }}}, {{{ $user->state_province }}} {{{ $user->postal_code }}}<br/>
                    {{{ $user->email_address }}}<br/>
                    {{{ isset($user->phone_number) ? $user->phone_number : '' }}}
                </div>
            </div>
    </div>
    </div>
@stop
