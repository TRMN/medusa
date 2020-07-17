@extends('layout')

@section('pageTitle')
    Manage / Enter Grades
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Manage / Enter Grades</h1>

    <div class="row">
        <div class=" col-sm-6 ninety Incised901Light ">
            {!!Form::text('query', '', ['id' => 'query', 'placeholder' => 'Start typing member number or name', 'class' => 'form-control'])!!}
        </div>
    </div>
    @if(!empty($user->first_name))
        <div id="member">
            @include('partials.greeting', ['user' => $user])
            @include('partials.assignments', ['user' => $user])
            @include('partials.coursework', ['user' => $user])
            <br/>
            <div class="row">
                {!!Form::open(['route' => 'exam.update', 'id' => 'exam_form'])!!}
                {!! Form::hidden('member_id', $user->member_id) !!}
                <div class=" col-sm-3 ninety Incised901Light form-group">{!!Form::text('exam', '', ['id' => 'exam', 'placeholder' => 'Start typing Exam ID', 'class' => 'form-control'])!!}</div>
                <div class=" col-sm-3 ninety Incised901Light form-group">{!!Form::text('score', '', ['id' => 'score', 'placeholder' => 'Exam Score', 'class' => 'form-control'])!!}</div>
                <div class=" col-sm-3 ninety Incised901Light form-group">{!!Form::date('date', '', ['id' => 'date', 'placeholder' => 'Exam Date (YYYY-MM-DD)', 'class' => 'form-control'])!!}</div>
            </div>
            <div class="row">
                <div class=" col-sm-9 ninety Incised901Light text-center">
                    <a class="btn btn-warning"
                       href="{!! URL::route('exam.find', ['user' => $user->id]) !!}"><span class="fa fa-times"></span>
                        <strong>Cancel</strong> </a>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong>
                    </button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    @endif
@stop
@section('scriptFooter')
    <script type="text/javascript">
        $('#query').devbridgeAutocomplete({
            serviceUrl: '/api/find',
            onSelect: function (suggestion) {
                window.location = '/exam/find/' + suggestion.data;
            },
            width: 600
        });
        $('#exam').devbridgeAutocomplete({
            serviceUrl: '/api/exam',
            onSelect: function (suggestion) {
                $('#exam').val(suggestion.data);
                //$('#exam_query').val(suggestion.data);
                $('#exam').prop('disabled', true);
                $('#score').focus();
            },
            width: 600
        });

        $('#exam_form').on('submit', function () {
            $('#exam').prop('disabled', false);
            $('#score').val(function (i, score) {
                return score.replace('%', '');
            });
        });

        $(window).load(function () {
            if ($('#exam').val().length > 0) {
                $('#exam').prop('disabled', true);
            }

        });
    </script>
@stop