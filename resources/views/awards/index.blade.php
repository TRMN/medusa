@extends('layout')

@section('pageTitle')
    Manage Awards
@stop

@section('dochead')
@stop

@section('content')
    <h3 class="text-center">Manage Awards</h3>
    <div class="row">
        <div class="col-sm-6">
            <p>Drag and drop awards to change the order that the ribbons will appear.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-group list-group-sortable-handles sortable">
                @foreach(App\Award::where('display_order', '<', 1000)->where('location', '!=', 'AWQ')->orderBy('display_order')->get() as $award)
                    <li class="list-group-item text-center nobackground" draggable="true"
                        data-display_order="{{$award->display_order}}" data-code="{{$award->code}}">
                        @if(file_exists(public_path('ribbons/' . $award->code . '-1.svg')))
                            <img src="{!!asset('ribbons/' . $award->code . '-1.svg')!!}" alt="{!!$award->name!!}"
                                 class="ribbon padding-bottom-10"><br/>
                        @endif
                        {{$award->name}}<br/>
                        <div class="padding-top-10 btn-group-xs">
                            <button id="editBtn" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#awardForm"
                                    data-code="{{$award->code}}" data-name="{{$award->name}}"
                                    data-postnom="{{$award->post_nominal}}" data-location="{{$award->location}}"
                                    data-replaces="{{$award->replaces}}" data-multiple="{{$award->multiple}}"
                                    data-points="{{$award->points}}" data-nation="{{$award->star_nation}}"><span class="fa fa-edit"></span> Edit
                            </button>
                            <button id="addBtn" class="btn btn-xs btn-success"> Insert award below <span
                                        class="fa fa-arrow-down"></span></button>
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div id="awardForm" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-title">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="text-center"><span id="formType"></span> Award</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="awardName" class="control-label col-sm-5">Name</label>
                            <div class="col-sm-7">
                                <input type="text" id="awardName" class="form-control" placeholder="Award Name"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="awardCode" class="control-label col-sm-5">Code</label>
                            <div class="col-sm-5">
                                <input type="text" id="awardCode" class="form-control" placeholder="Award Code"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postNominals" class="control-label col-sm-5">Post-nominals</label>
                            <div class="col-sm-5">
                                <input type="text" id="postNominals" class="form-control"
                                       placeholder="Post-nominals (if any)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="awardLocation" class="control-label col-sm-5">Ribbon Location</label>
                            <div class="col-sm-5">
                                <select id="awardLocation" class="form-control" required>
                                    <option>Select Location</option>
                                    <option value="L">Left</option>
                                    <option value="R">Right</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 text-right">
                                <input type="checkbox" id="awardMultiple" value="true">
                            </div>
                            <div class="col-sm-7">
                                <label for="awardMultiple" class="control-label">Can receive more than one</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="awardReplaces" class="control-label col-sm-5">Replaces these awards</label>
                            <div class="col-sm-7">
                                <select id="awardReplaces" class="white-border" multiple>
                                    <option value="">Replaces these awards (if any)</option>
                                    @foreach(App\Award::whereIn('location', ['L', 'R'])->orderBy('display_order')->get() as $ribbon)
                                        <option value="{{$ribbon->code}}">{{$ribbon->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ppoints" class="control-label col-sm-5">Promotion Points</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="ppoints" required step="0.5" min="0.5"
                                       max="5">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="starNation" class="control-label col-sm-5">Issuing Star Nation</label>
                            <div class="col-sm-7">
                                <select id="starNation" class="form-control" required>
                                    <option value="">Choose a Star Nation</option>
                                    @foreach(\App\MedusaConfig::get('starnations') as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-center hidden" id="fifteen">
                            <div class="row">
                                <div class="col-sm-4 text-center">First Award</div>
                                <div class="col-sm-4 text-center">Second Award</div>
                                <div class="col-sm-4 text-center">Third Award</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 text-center"><img class="mimg img1"></div>
                                <div class="col-sm-4 text-center"><img class="mimg img2"></div>
                                <div class="col-sm-4 text-center"><img class="mimg img3"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 text-center">Fourth Award</div>
                                <div class="col-sm-3 text-center">Fifth Award</div>
                                <div class="col-sm-3 text-center">Tenth Award</div>
                                <div class="col-sm-3 text-center">Fifteenth Award</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 text-center"><img class="mimg img4"></div>
                                <div class="col-sm-3 text-center"><img class="mimg img5"></div>
                                <div class="col-sm-3 text-center"><img class="mimg img10"></div>
                                <div class="col-sm-3 text-center"><img class="mimg img15"></div>
                            </div>
                        </div>
                        <div class="text-center hidden" id="five">
                            <div class="row">
                                <div class="col-sm-3">&nbsp;</div>
                                <div class="col-sm-3 text-center">First Award</div>
                                <div class="col-sm-3 text-center">Second Award</div>
                                <div class="col-sm-3">&nbsp;</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">&nbsp;</div>
                                <div class="col-sm-3 text-center"><img class="mimg img1"></div>
                                <div class="col-sm-3 text-center"><img class="mimg img2"></div>
                                <div class="col-sm-3">&nbsp;</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 text-center">Third Award</div>
                                <div class="col-sm-4 text-center">Fourth Award</div>
                                <div class="col-sm-4 text-center">Fifth Award</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 text-center"><img class="mimg img3"></div>
                                <div class="col-sm-4 text-center"><img class="mimg img4"></div>
                                <div class="col-sm-4 text-center"><img class="mimg img5"></div>
                            </div>
                        </div>
                        <div class="text-center hidden" id="one">
                            <img class="mimg img1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span
                                class="fa fa-times"></span>
                        <storng>Cancel</storng>
                    </button>
                    <button class="btn btn-success" type="submit" id="awardFormSubmit"><span class="fa fa-save"></span>
                        <strong>Save</strong></button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scriptFooter')
    <script type="text/javascript">
        $(function () {
            $('.sortable').sortable().bind('sortupdate', function (e, ui) {
                console.log('Starting ribbon renumber');
                var display_order = 1;
                var data = [];
                $('.sortable li').each(function () {
                    var e = $(this);
                    var code = e.data('code');
                    data.push({
                        "code": code,
                        "display_order": display_order
                    });
                    display_order++;
                });
                console.log('Ribbon renumber completed');
                console.log(data);

                $.ajax({
                    url: "/api/awards/updateOrder",
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                })
                    .done(function (response) {
                        if (response.status === 'error') {
                            alert(response.msg);
                        }
                    });
            });

            $('#awardReplaces').selectize({
                plugins: ['remove_button'],
                hideSelected: true,
                maxItems: null
            });

            $('#awardForm').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal

                if (typeof awardCode !== 'undefined') {
                    $('#formType').text('Edit');
                } else {
                    $('#formType').text('Add');
                }

                var $select = $('#awardReplaces').selectize();
                var selectize = $select[0].selectize;
                selectize.clear();

                if (button.attr('id') === 'editBtn') {
                    var awardCode = button.data('code');
                    var awardName = button.data('name');
                    var awardPostnom = button.data('postnom');
                    var location = button.data('location');
                    var replaces = button.data('replaces').split(',');
                    var multiple = button.data('multiple');
                    var points = button.data('points');
                    var nation = button.data('nation');
                    $('#awardCode').val(awardCode);
                    $('#awardCode').attr('disabled', true);
                    $('#awardName').val(awardName);
                    $('#postNominals').val(awardPostnom);
                    $('#ppoints').val(points);
                    $('#awardMultiple').prop('checked', multiple);
                    $('#awardLocation').val(location);
                    $('#starNation').val(nation);

                    $.each(replaces, function (key, value) {
                        selectize.addItem(value);
                    });

                    selectize.refreshItems();

                    if (multiple) {
                        $.get('/ribbons/' + awardCode + '-15.svg')
                            .done(function (data, textStatus, jqXHR) {
                                getRibbons([1, 2, 3, 4, 5, 10, 15], awardCode);
                                $('#fifteen').removeClass('hidden');
                            })
                            .fail(function (jqXHR, textStatus, errorThrown) {
                                getRibbons([1, 2, 3, 4, 5], awardCode);
                                $('#five').removeClass('hidden');
                            })
                    } else {
                        $('.img1').attr('src', '/ribbons/' + awardCode + '-1.svg');
                        $('#one').removeClass('hidden');
                    }
                }
            });

            $('#awardForm').on('hide.bs.modal', function (event) {
                $.each(['#one', '#five', '#fifteen'], function (key, value) {
                    if (!$(value).hasClass('hidden')) {
                        $(value).addClass('hidden')
                    }
                });
            });

            function getRibbons(ribbonList, awardCode) {
                $.each(ribbonList, function (key, value) {
                    var image_url = '/ribbons/' + awardCode + '-' + value + '.svg';
                    $.get(image_url)
                        .done(function () {
                            $('.img' + value).attr('src', image_url);
                        })
                });
            }
        });
    </script>
@endsection