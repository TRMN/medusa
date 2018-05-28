@extends('layout')

@section('pageTitle')
    Promote/Demote {!! $user->getGreeting() !!} {!! $user->first_name !!}{{ isset( $user->middle_name ) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ isset( $user->suffix ) ? ' ' . $user->suffix : '' }}
@stop

@section('dochead')

@stop

@section('bodyclasses')
    userform
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <h4 class="my NordItalic ninety">
                Promote/Demote {!! $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
                {!! $user->last_name !!}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}</h4><br />


            {!! Form::model( $user, [ 'route' => [ 'user.update', $user->id ], 'method' => 'put', 'id' => 'user' ] ) !!}

            <div class="row">
                <div class="col-sm-6 Incised901Light form-group">
                    {!! Form::label('display_rank', "New Rank", ['class' => 'my']) !!} {!! Form::select('display_rank', $grades, $user->display_rank, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 Incised901Light form-group">
                    {!! Form::label('dor', "New   Date of Rank", ['class' => 'my']) !!} {!! Form::date('dor', $user->dor, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 Incised901Light">
                    {{Form::checkbox('checkTig', 1, true, ['id' => 'checkTig'])}} Check Time in Grade
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 text-center">
                    <button class="btn btn-success" type="submit" id="updateRankBtn"><span class="fa fa-save"></span> Save Changes</button>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection

@section('footerJS')

@endsection