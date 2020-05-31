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
            <p>Only use this option if you are requesting a branch change. If you are only requesting a chapter change,
                you do not need to select a branch.</p>
            <div class="form-group form-inline">
                {!! Form::label('Change branch from ' . $branches[$user->branch] . ' to ') !!} {!! Form::select('new_branch', $branches, null, ['class' => 'selectize form-control']) !!}
            </div>
            {{--            <p>Change Branch from&nbsp;<span class="bg-primary"> {!!$branches[$user->branch]!!} </span>&nbsp;to--}}

            {!! Form::hidden('old_branch', $user->branch) !!}</p>
            <p id="new-rank-wrapper">If approved, your new rank will be <span class="bg-primary" id="new-rank"></span>.
            </p>
        </fieldset>

        <fieldset>
            <legend>Chapter Change Request</legend>
            <p>Only use this option if you are requesting a change to your primary chapter. If you are only requesting a
                branch change, you do not need to select a chapter.</p>
            <p>Change Chapter From&nbsp;<span class="bg-primary">
                @if($user->getAssignmentName('primary') == 'HMS Charon')
                        HMS Charon
                    @else
                        {!!$allchapters[$user->getAssignmentId('primary')]!!}
                    @endif
                </span>&nbsp;to</p>
            <div class="row">
                <div class=" col-sm-6  ninety Incised901Light">
                    {!! Form::label('primary_assignment', "Chapter", ['class' => 'my']) !!} {!! Form::select('primary_assignment', $chapters, null, ['placeholder' => 'Start typing to search for a chapter', 'class' => 'selectize']) !!}
                    {!! Form::hidden('old_assignment', $user->getAssignmentId('primary')) !!}
                </div>
            </div>
        </fieldset>
    </div>
    {!! Form::submit('Save', [ 'class' => 'btn btn-success' ] ) !!}

    {!! Form::close() !!}
@stop

@section('scriptFooter')
    <script type="text/ecmascript">
        $(function () {
            $('#new-rank-wrapper').hide();

            $(':input[name="new_branch"]').on('change', function () {
                $.ajax('/api/rank/transfer/{{ $user->id }}/' + $(':input[name="old_branch"]').val() + '/' + $(':input[name="new_branch"]').val())
                    .done(function (data) {
                        $('#new-rank').html(data.new_rank);
                        $('#new-rank-wrapper').show();
                    })
            });
        });
    </script>

    <style>
        .selectize-input {
            width: 400px;
            min-height: 1.5em;
        }

        .selectize-dropdown {
            background: black !important;
            color: #f5f5f5 !important;
        }

        #new-rank {
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
@stop
