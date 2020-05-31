@extends('layout')
@section('pageTitle')
    Pay Grade Tools
@stop
@section('content')
    <div id="user">
        <h1 class="text-center">Pay Grade Tools</h1>
        <fieldset>
            <legend>Select A Member</legend>
            <div class="row">
                <div class=" col-sm-6 ninety Incised901Light ">
                    {!!Form::text('query', '', ['id' => 'query', 'placeholder' => 'Start typing member number or name', 'class' => 'form-control'])!!}
                    {!! Form::hidden('id', null, ['id' => 'id']) !!}
                </div>
            </div>
        </fieldset>

        <fieldset id="tools">
            <legend>Member Utilities</legend>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#promotion"
                               aria-expanded="true" aria-controls="promotion">
                                Check Promotion Eligibility
                            </a>
                        </h4>
                    </div>
                    <div id="promotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body black-background">
                            <div class="row">
                                <div class="col-sm-2 form-group-sm vcenter">
                                    {!! Form::label('pay_grade', 'Rank to Check') !!}
                                </div>
                                <div class="col-sm-3 form-group-sm vcenter">
                                    {!! Form::select('pay_grade',[], null, ['class' => 'form-control', 'id' => 'paygrade']) !!}
                                </div>
                                <div class="col-sm-3 form-group-sm vcenter">
                                    <button class="btn btn-primary" id="btnPromotion">Check Eligibility</button>
                                </div>
                            </div>
                            <br/>
                            <div class="row" id="promotion-results">
                                <div class="col-sm-4 text-center"><span id="tig"
                                                                        class="fa size-36 vcenter">&nbsp;</span>Time In
                                    Grade
                                </div>
                                <div class="col-sm-4 text-center"><span id="pp" class="fa size-36 vcenter">&nbsp;</span>Promotion
                                    Points
                                </div>
                                <div class="col-sm-4 text-center"><span id="exams"
                                                                        class="fa size-36 vcenter">&nbsp;</span>Required
                                    Exam(s)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#transfer" aria-expanded="false" aria-controls="transfer">
                                Branch Transfer Check
                            </a>
                        </h4>
                    </div>
                    <div id="transfer" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body black-background">
                            <div class="row">
                                <div class="col-sm-3 form-group vcenter">
                                    Transfer from <span id="from-branch"></span> to
                                </div>
                                <div class="col-sm-3 form-group vcenter">
                                    {!! Form::select('branch_list', [], null, ['class' => 'form-control', 'id' => 'to-branch']) !!}
                                </div>
                                <div class="col-sm-2 form-group vcenter">
                                    <button class="btn btn-primary" id="btnTransfer">See New Rank</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 vcenter">
                                    <span id="new-rank"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Pay Grade Chart</legend>
            <div class="row">
                <div class="col-sm-3 form-group vcenter">
                    {!! Form::select('branch_list', [], null, ['class' => 'form-control', 'id' => 'branches']) !!}
                </div>
                <div class="col-sm-2 form-group vcenter">
                    <button class="btn btn-primary" id="btnPayGradeChart">See Pay Grade Chart</button>
                </div>
            </div>
            <div class="row" id="rank-chart-wrapper">
                <table class="compact row-border" id="rank-chart">
                    <thead>
                    <tr>
                        <th class="text-center">Pay Grade</th>
                        <th class="text-center">Rank Title</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="text-center">Pay Grade</th>
                        <th class="text-center">Rank Title</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </fieldset>
    </div>
@stop
@section('scriptFooter')
    <script type="text/javascript">
        $(function () {
            $('#promotion-results').hide();
            $('#tools').hide();
            $('#rank-chart').DataTable({
                "ordering": false,
                "deferRender": true,
                "pageLength": 15,
                "lengthChange": false
            });
            $('#rank-chart-wrapper').hide();

            $.get("/api/branch")
                .done(function (data) {
                    $('#to-branch').empty();
                    let options = '';
                    jQuery.each(data, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                    $('#to-branch').append(options);
                });

            $.get("/api/branch/enhanced")
                .done(function (data) {
                    $('#branches').empty();
                    let options = '';
                    jQuery.each(data, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                    $('#branches').append(options);
                });

            $('#query').devbridgeAutocomplete({
                serviceUrl: '/api/find',
                onSelect: function (suggestion) {
                    $('#id').val(suggestion.data);
                    $('#tools').show();
                    let payload = {
                        "id": suggestion.data
                    };
                    $.ajax({
                        method: "GET",
                        url: "/api/paygradesforuser/" + suggestion.data,
                    })
                        .done(function (data) {
                                $('#paygrade').empty();
                                let options = '<option value="">Select a Rank</option>';
                                jQuery.each(data, function (key, value) {
                                    options += '<optgroup label="' + key + '">';

                                    jQuery.each(value, function (key2, value2) {
                                        options += '<option value="' + key2 + '">' + value2 + '</option>';
                                    });

                                    options += '</optgroup>';
                                });
                                $('#paygrade').append(options);
                            }
                        );
                    $.ajax({
                        method: "GET",
                        url: "/api/branchforuser/" + suggestion.data,
                    })
                        .done(function (data) {
                            $('#from-branch').html(data);
                        });
                },
                width: 600
            });

            $('#btnPayGradeChart').on('click', function () {
                $('#tools').hide();
                let branch = $('#branches :selected').val();
                $.get('/api/branch/' + branch + '/grade/unfiltered')
                    .done(function (paygrades) {
                        $('#rank-chart').DataTable().clear().rows.add(paygrades).draw();
                        $('#rank-chart-wrapper').show();
                    });
            });

            $('#btnTransfer').on('click', function () {
                let memberid = $('#id').val();
                let newBranch = $('#to-branch :selected').val();
                $.ajax({
                    method: "GET",
                    url: "/api/checktransferrank/" + memberid + "/" + newBranch
                })
                    .done(function (data) {
                        $('#new-rank').html(data);
                    });
            });

            $('#btnPromotion').on('click', function () {
                let memberid = $('#id').val();
                let paygrade = $('#paygrade :selected').val();

                clearIndicators('#tig');
                clearIndicators('#pp');
                clearIndicators('#exams');

                $.ajax({
                    method: "GET",
                    url: "api/promotioninfo/" + memberid + "/" + paygrade
                })
                    .done(function (data) {
                        if (data.tig === true) {
                            passed('#tig');
                        } else {
                            failed('#tig');
                        }

                        if (data.points === true) {
                            passed('#pp');
                        } else {
                            failed('#pp');
                        }

                        if (data.exams === true) {
                            passed('#exams');
                        } else {
                            failed('#exams');
                        }

                        $('#promotion-results').show();
                    });
            });

            function passed(selector) {
                $(selector).addClass('fa-check-square-o')
                $(selector).addClass('green');
            }

            function failed(selector) {
                $(selector).addClass('fa-window-close-o');
                $(selector).addClass('red');
            }

            function clearIndicators(selector) {
                $(selector).removeClass('red');
                $(selector).removeClass('green');
                $(selector).removeClass('fa-window-close-o');
                $(selector).removeClass('fa-check-square-o');
            }
        });
    </script>
@stop