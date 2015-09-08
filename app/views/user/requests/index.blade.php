@extends('layout')

@section('pageTitle')
    Assignment Change Request
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Assignment Change Request</h1>

    <?php
    if (count($errors->all())) {
        echo "<p>Please correct the following errors:</p>\n<ul>\n";
        foreach ($errors->all() as $message) {
            echo "<li>" . $message . "</li>\n";
        }
    }
    echo "</ul>\n";
    ?>

    {{ Form::model( $user, ['route' => 'user.change.store', 'method' => 'post', 'id' => 'changeRequest' ] ) }}
    <div id="user" class="userform">
        <fieldset>
            <legend>Requested For</legend>
            {{ $user->getGreeting() }} {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}
            {{ Form::hidden('user_id', $user->id) }}
        </fieldset>
        @if($user->id != $req->id)
            <fieldset>
                <legend>Requested By</legend>
                {{ $req->getGreeting() }} {{ $req->first_name }}{{ isset($req->middle_name) ? ' ' . $req->middle_name : '' }} {{ $req->last_name }}{{ !empty($req->suffix) ? ' ' . $req->suffix : '' }}
                , {{$req->branch}}
                {{ Form::hidden('req_id', $req->id) }}
            </fieldset>
        @endif
        <fieldset>
            <legend>Change Branch From {{$branches[$user->branch]}} to</legend>
            {{ Form::select('branch', $branches, '') }}
            {{ Form::hidden('old_branch', $user->branch) }}
        </fieldset>
        <fieldset>
            <legend>Change Billet From {{$user->getPrimaryBillet()}} to</legend>
            {{ Form::select('primary_billet', $billets) }}
            {{ Form::hidden('old_billet', $user->getPrimaryBillet()) }}
        </fieldset>
        <fieldset>
            <legend>Change Chapter From {{$chapters[$user->getPrimaryAssignmentId()]}} to</legend>
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label( 'plocation', 'Location', ['class' => 'my']) }} {{ Form::select('plocation', $locations) }}
                </div>
            </div>
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('primary_assignment', "Chapter", ['class' => 'my']) }} {{ Form::select('primary_assignment', $chapters) }}
                    {{ Form::hidden('old_assignment', $user->getPrimaryAssignmentId()) }}
                </div>
            </div>
        </fieldset>
    </div>
    {{ Form::submit('Save', [ 'class' => 'button' ] ) }}

    {{ Form::close() }}
@stop

