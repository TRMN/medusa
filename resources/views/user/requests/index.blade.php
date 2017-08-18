@extends('layout')

@section('pageTitle')
    Assignment Change Request
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Assignment Change Request</h1>

    {!! Form::model( $user, ['route' => 'user.change.store', 'method' => 'post', 'id' => 'changeRequest' ] ) !!}
    <div id="user" class="userform">
        <fieldset>
            <legend>Requested For</legend>
            {!! $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}
            {!! Form::hidden('user_id', $user->id) !!}
        </fieldset>
        @if($user->id != $req->id)
            <fieldset>
                <legend>Requested By</legend>
                {!! $req->getGreeting() !!} {!! $req->first_name !!}{{ isset($req->middle_name) ? ' ' . $req->middle_name : '' }} {!! $req->last_name !!}{{ !empty($req->suffix) ? ' ' . $req->suffix : '' }}
                , {!!$req->branch!!}
                {!! Form::hidden('req_id', $req->id) !!}
            </fieldset>
        @endif
        <fieldset>
            <legend>Branch Change Request</legend>
            <p>Only use this option if you are requesting a branch change.  If you are only requesting a chapter change, you do not need to select a branch.</p>
            <p>Change Branch From {!!$branches[$user->branch]!!} to</p>
            {!! Form::select('new_branch', $branches, null, ['class' => 'selectize']) !!}
            {!! Form::hidden('old_branch', $user->branch) !!}
        </fieldset>

        <fieldset>
            <legend>Chapter Change Request</legend>
            <p>Only use this option if you are requesting a chapter change.  If you are only requesting a branch change, you do not need to select a chapter.</p>
            <p>Change Chapter From
                @if($user->getAssignmentName('primary') == 'HMS Charon')
                    HMS Charon
                @else
                    {!!$allchapters[$user->getAssignmentId('primary')]!!}
                @endif
                to</p>
            <div class="row">
                <div class=" col-sm-6  ninety Incised901Light">
                    {!! Form::label('primary_assignment', "Chapter", ['class' => 'my']) !!} {!! Form::select('primary_assignment', $chapters, null, ['placeholder' => 'Start typing to search for a chapter', 'class' => 'selectize']) !!}
                    {!! Form::hidden('old_assignment', $user->getAssignmentId('primary')) !!}
                </div>
            </div>
        </fieldset>
    </div>
    {!! Form::submit('Save', [ 'class' => 'btn' ] ) !!}

    {!! Form::close() !!}
@stop

