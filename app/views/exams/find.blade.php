@extends('layout')

@section('pageTitle')
    Manage / Enter Grades
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Manage / Enter Grades</h1>

    <div class="row">
        <div class="columns small-6 ninety Incised901Light end">
            {{Form::text('query', '', ['id' => 'query', 'placeholder' => 'Start typing member number or name'])}}
        </div>
    </div>
    @if(!is_null($user))
        <div id="member">
            @include('partials.greeting', ['user' => $user])
            @include('partials.assignments', ['user' => $user])
            @include('partials.coursework', ['user' => $user])
            <br/>
            <div class="row">
                {{Form::open(['route' => 'exam.update', 'id' => 'exam_form'])}}
                {{ Form::hidden('member_id', $user->member_id) }}
                <div class="columns small-3 ninety Incised901Light">{{Form::text('exam', '', ['id' => 'exam', 'placeholder' => 'Start typing Exam ID'])}}</div>
                <div class="columns small-3 ninety Incised901Light">{{Form::text('score', '', ['id' => 'score', 'placeholder' => 'Exam Score'])}}</div>
                <div class="columns small-3 ninety Incised901Light end">{{Form::date('date', '', ['id' => 'date', 'placeholder' => 'Exam Date (YYYY-MM-DD)'])}}</div>
            </div>
            <div class="row">
                <div class="columns small-3 ninety Incised901Light end">
                    <a class="button"
                       href="{{ URL::route('exam.find', ['user' => $user->id]) }}">Cancel</a> {{ Form::submit('Save', [ 'class' => 'button' ] ) }}
                </div>
                {{Form::close()}}
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
            }
        });
        $('#exam').devbridgeAutocomplete({
            serviceUrl: '/api/exam',
            onSelect: function (suggestion) {
                $('#exam').val(suggestion.data);
                //$('#exam_query').val(suggestion.data);
                $('#exam').prop('disabled', true);
                $('#score').focus();
            }
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