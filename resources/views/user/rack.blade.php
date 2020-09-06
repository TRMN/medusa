@extends('layout')

@section('pageTitle')
    Ribbon Rack Builder
@stop

@section('dochead')
@stop

@section('content')
    @php
        $groupCount = 0;
        $hasEdit_RR = Auth::user()->hasPermission(['EDIT_RR']);
    @endphp
    <div class="row">
        <h1 class="text-center">Ribbon Rack Builder
            for {{  $user->getGreeting() }} {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}</h1>
        {!! \App\MedusaConfig::get('rr.instructions') !!}
    </div>

    {{ Form::open(['route' => ['saverack', $user]]) }}
    <div class="row text-center"><h3>Name Badge</h3></div>
    <div class="ribbon-group">
        @if(!is_null($user->getNameofLands()) && in_array($user->branch, ['RMN', 'RMMC', 'RMA']))
            <br/>
            <div class="row ribbon-row">
                <div class="col-sm-1">
                    {{Form::checkbox('usePeerageLands', 1, isset($user->usePeerageLands)?true:null)}}
                </div>
                <div class="col-sm-7 ">
                    Use <strong><em>{{$user->getNameofLands()}}</em></strong> on name badge
                </div>
            </div>
        @endif
        <div class="row ribbon-row">
            <div class="col-sm-1">
                {{Form::checkbox('extraPadding', 1, isset($user->extraPadding)?true:null)}}
            </div>
            <div class="col-sm-7 ">
                Use extra padding on name badge for long names
            </div>
        </div>
    </div>
    <br clear="both"/>

    @foreach(App\Award::getLeftSleeve() as $badge)
        <div class="row ribbon-row clearfix">
            <div class="col-sm-1">
                {{Form::checkbox('ribbon[]', $badge->code, isset($user->awards[$badge->code])?true:null)}}
            </div>
            <div class="col-sm-2 text-center">
                @if(file_exists(public_path('images/' . $badge->code . '.svg')))
                    <img src="{{asset('images/' . $badge->code . '.svg')}}" alt="{{$badge->name}}" class="height54px">
                @else
                    {{ $badge->name }}
                @endif
            </div>
            <div class="col-sm-5">
                @if($badge->multiple)
                    {{Form::number($badge->code . '_quantity', isset($user->awards[$badge->code])?$user->awards[$badge->code]['count']:0, ['min' => 0])}}
                @else
                    {{Form::hidden($badge->code . '_quantity', '1')}}
                @endif
            </div>
        </div>
    @endforeach


    <br clear="both"/>
    <div class="row text-center"><h3>Unit Patch</h3></div>
    @if(!empty($unitPatchPaths))
        <div class="ribbon-group">
            <div class="row patch-row">
                <div class="col-sm-1">&nbsp;</div>
                <div class="col-sm-2 text-center">
                    <img src="{{ empty($user->unitPatchPath)? '/' . current(array_flip(array_slice($unitPatchPaths, 0, 1))) : '/' . $user->unitPatchPath}}"
                         id="patchImage"/><br/>
                    {{ Form::select('unitPatch', $unitPatchPaths, empty($user->unitPatchPath)? null : $user->unitPatchPath, ['id' => 'unitPatch']) }}
                </div>
                <div class="col-sm-5 "></div>
            </div>
        </div>
    @else
        <div class="ribbon-group">
            <div class="row patch-row">
                <div class="col-sm-8 ">
                    No artwork is currently available for any of your current assignments. Please check back as new
                    artwork is being added all the time.
                </div>
            </div>
        </div>

    @endif
    <br clear="both"/>

    <div class="row text-center"><h3>Award Stripes</h3></div>
    <div class="ribbon-group">
        @foreach(App\Award::getRightSleeve() as $badge)
            @if(file_exists(public_path('awards/stripes/' . $badge->code . '-1.svg')))
                <div class="row ribbon-group-row">
                    <div class="col-sm-1">
                        {{Form::checkbox('ribbon[]', $badge->code, isset($user->awards[$badge->code])?true:null, ['class' => 'ribbon-check', 'id' => $badge->code . '-select', 'data-code' => $badge->code])}}
                    </div>
                    <div class="col-sm-2 text-center" id="{{$badge->code}}">
                        @set('ribbon_image', null)
                        @if(isset($user->awards[$badge->code]) && file_exists(public_path('awards/stripes/' . $badge->code . '-' . $user->awards[$badge->code]['count'] . '.svg')))
                            @set('ribbon_image', 'awards/stripes/' . $badge->code . '-' .
                            $user->awards[$badge->code]['count'] . '.svg')
                        @elseif (file_exists(public_path('awards/stripes/' . $badge->code . '-1.svg')))
                            @set('ribbon_image, 'awards/stripes/' . $badge->code . '-1.svg')
                        @endif
                        @if(!is_null($ribbon_image))
                            <img src="{{asset($ribbon_image)}}" alt="{{$badge->name}}">
                        @endif
                    </div>
                    <div class="col-sm-4"><br/><br/>{{$badge->name}}</div>
                    <div class="col-sm-1 ">
                        @if($badge->multiple)
                            {{Form::number($badge->code . '_quantity', isset($user->awards[$badge->code])?$user->awards[$badge->code]['count']:0, ['min' => 0, 'data-code' => $badge->code, 'data-name' => $badge->name, 'class' => 'ribbon-quantity'])}}
                        @else
                            {{Form::hidden($badge->code . '_quantity', '1')}}
                        @endif
                    </div>
                </div>
                <br clear="both"/>
            @endif
        @endforeach
    </div>

    <div class="row text-center"><h3>Unit Citations</h3></div>
    <div class="ribbon-group padding-top-10">
        @foreach(App\Award::getRightRibbons() as $ribbon)
            @if(is_object($ribbon))
                <div class="row ribbon-group-row">
                    <div class="col-sm-1">
                        {{Form::checkbox('ribbon[]', $ribbon->code, isset($user->awards[$ribbon->code])?true:null, ['class' => 'ribbon-check', 'id' => $ribbon->code . '-select', 'data-code' => $ribbon->code])}}
                    </div>
                    <div class="col-sm-2 text-center" id="{{$ribbon->code}}">
                        @set('ribbon_image', null)
                        @if(isset($user->awards[$ribbon->code]) && file_exists(public_path('ribbons/' . $ribbon->code . '-' . $user->awards[$ribbon->code]['count'] . '.svg')))
                            @set('ribbon_image', 'ribbons/' . $ribbon->code . '-' .
                            $user->awards[$ribbon->code]['count'] . '.svg')
                        @elseif (file_exists(public_path('ribbons/' . $ribbon->code . '-1.svg')))
                            @set('ribbon_image, 'ribbons/' . $ribbon->code . '-1.svg')
                        @endif
                        @if(!is_null($ribbon_image))
                            <img src="{{asset($ribbon_image)}}" alt="{{$ribbon->name}}" class="ribbon">
                        @endif
                    </div>
                    <div class="col-sm-4">{{$ribbon->name}}</div>
                    <div class="col-sm-1 ">
                        @if($ribbon->multiple)
                            {{Form::number($ribbon->code . '_quantity', isset($user->awards[$ribbon->code])?$user->awards[$ribbon->code]['count']:0, ['min' => 0, 'data-code' => $ribbon->code, 'data-name' => $ribbon->name, 'class' => 'ribbon-quantity'])}}
                        @else
                            {{Form::hidden($ribbon->code . '_quantity', '1')}}
                        @endif
                    </div>
                </div>
            @else
                @if($ribbon['group']['multiple'])
                    <div class="ribbon-group">
                        @foreach($ribbon['group']['awards'] as $group)

                            <div class="row ribbon-group-row">
                                <div class="col-sm-1">
                                    {{Form::radio('group' . $groupCount, $group->code, isset($user->awards[$group->code])?true:null)}}
                                </div>
                                <div class="col-sm-2 text-center">
                                    @if(file_exists(public_path('ribbons/' . $group->code . '-1.svg')))
                                        <img src="{{asset('ribbons/' . $group->code . '-1.svg')}}"
                                             alt="{{$group->name}}" class="ribbon">
                                    @endif
                                </div>
                                <div class="col-sm-4">{{$group->name}}</div>
                                <div class="col-sm-1 ">
                                    @if($group->multiple)
                                        {{Form::number($group->code . '_quantity', isset($user->awards[$group->code])?$user->awards[$group->code]['count']:0, ['min' => 0])}}
                                    @else
                                        {{Form::hidden($group->code . '_quantity', '1')}}
                                    @endif
                                </div>
                            </div>

                        @endforeach
                        <div class="row ribbon-group-row">
                            <div class="col-sm-1">
                                {{Form::radio('group' . $groupCount, null)}}
                            </div>
                            <div class="col-sm-2 text-center">&nbsp;</div>
                            <div class="col-sm-4 ">None of the above</div>
                        </div>
                    </div>
                @else
                    <div class="row ribbon-group-row">
                        <div class="col-sm-1">
                            {{Form::checkbox('select' . $groupCount . '_chk', 1, false, ['id' => 'select' . $groupCount . '_chk'])}}
                        </div>
                        <div class="col-sm-2 text-center">
                            <img id="select{{$groupCount}}_img" class="ribbon"/>
                        </div>
                        <div class="col-sm-5 "><select name="select{{$groupCount}}" id="select{{$groupCount}}"
                                                       class="ribbon_group_select">
                                <option value="">{{$ribbon['group']['label']}}</option>
                                @foreach($ribbon['group']['awards'] as $item)
                                    {{--                                    @if(file_exists(public_path('ribbons/' . $item->code . '-1.svg')))--}}
                                    <option value='{"code": "{{$item->code}}", "img": "select{{$groupCount}}_img", "chk":  "select{{$groupCount}}_chk", "imgbase": "/ribbons/"}'{{isset($user->awards[$item->code])?' selected':''}}>{{$item->name}}</option>
                                    {{--@endif--}}
                                @endforeach
                            </select></div>
                    </div>

                @endif
            @endif
            <br clear="both"/>
            @php
                $groupCount++;
            @endphp
        @endforeach
    </div>

    <div class="row text-center"><h3>Qualification Badges</h3></div>
    <div class="ribbon-group">
        <div class="row ribbon-group-row">
            <div class="col-sm-8">&nbsp;</div>
            <div class="col-sm-2 text-center">Badge to display
            </div>
        </div>

        @foreach(App\Award::getTopBadges(['HS', 'OSWP', 'ESWP', 'CIB']) as $index => $badge)
            @foreach($badge['group']['awards'] as $group)
                @if(file_exists(public_path('awards/badges/' . $group->code . '-1.svg')))
                    <div class="row ribbon-group-row qual-badges">

                        <div class="col-sm-1 vertical-center-qual-badges">
                            @if(in_array($group->code, $restricted) && !$hasEdit_RR)
                                @if(isset($user->awards[$group->code]))
                                    {{Form::hidden('ribbon[]', $group->code)}}
                                @endif
                                &nbsp;
                            @else
                                {{Form::checkbox('ribbon[]', $group->code, isset($user->awards[$group->code])?true:null,  ['class' => 'ribbon-check', 'id' => $group->code . '-select', 'data-code' => $group->code])}}
                            @endif
                        </div>
                        <div class="col-sm-2 text-center">
                            <img src="{{asset('awards/badges/' . $group->code . '-1.svg')}}"
                                 alt="{{$group->name}}"
                                 class="{{$group->code === 'HS'? 'qual-badge-hs' : 'qual-badge'}}">
                        </div>
                        <div class="col-sm-4 vertical-center-qual-badges">{{$group->name}}</div>
                        <div class="col-sm-1 vertical-center-qual-badges">
                            @if($group->multiple)
                                @if(in_array($group->code, $restricted) && !isset($user->awards[$group->code]))
                                    &nbsp;
                                @else
                                    {{Form::number($group->code . '_quantity', isset($user->awards[$group->code])?$user->awards[$group->code]['count']:0, ['min' => 0])}}
                                @endif
                            @else
                                {{Form::hidden($group->code . '_quantity', '1')}}&nbsp;
                            @endif
                        </div>
                        <div class="col-sm-2 vertical-center-qual-badges qual-badges text-center">
                            @if(
                                (in_array($group->code, $restricted) && !isset($user->awards[$group->code])) ||
                                ($group->code == 'CIB' && ($user->branch != 'RMA') && !$user->hasPermission(['EDIT_RR'], true))
                            )
                                N/A
                            @else
                                {{Form::radio('qualbadge_display', $group->code, isset($user->awards[$group->code]['display'])?$user->awards[$group->code]['display']:false)}}
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach

        <div class="row ribbon-group-row qual-badges">
            <div class="col-sm-1 vertical-center-qual-badges">{{Form::checkbox('ribbon[]', 'SAW', isset($user->awards['SAW'])?true:null)}}</div>
            <div class="col-sm-2 text-center">
                <img src="{{asset('awards/badges/SAW-1.svg')}}"
                     alt="Solo Aerospace Wings" class="qual-badge">
            </div>
            <div class="col-sm-5 vertical-center-qual-badges">Solo Aerospace Wings</div>
            <div class="col-sm-1 vertical-center-qual-badges">{{Form::hidden('SAW_quantity', '1')}}</div>
            <div class="col-sm-2 vertical-center-qual-badges qual-badges text-center">
                {{Form::radio('qualbadge_display', 'SAW', isset($user->awards['SAV']['display'])?$user->awards['SAW']['display']:false)}}
            </div>
        </div>

        @foreach($wings as $desc => $wing)
            @foreach(App\Award::getAerospaceWings($wing) as $index => $ribbon)
                <div class="row ribbon-group-row qual-badges">
                    <div class="col-sm-1 vertical-center-qual-badges">{{Form::checkbox('select' . $groupCount . '_chk', 1, false, ['id' => 'select' . $groupCount . '_chk'])}}</div>
                    <div class="col-sm-2 text-center">
                        <img id="select{{$groupCount}}_img" class="qual-badge"/>
                    </div>
                    <div class="col-sm-5 top-15"><select name="select{{$groupCount}}" id="select{{$groupCount}}"
                                                         class="ribbon_group_select">
                            <option value="">Choose your {{$desc}}</option>
                            @foreach($ribbon['group']['awards'] as $item)
                                @if(file_exists(public_path('awards/badges/' . $item->code . '-1.svg')))
                                    <option value='{"code": "{{$item->code}}", "img": "select{{$groupCount}}_img", "chk":  "select{{$groupCount}}_chk", "imgbase": "/awards/badges/", "display": "display_{{$groupCount}}"}'{{isset($user->awards[$item->code])?' selected':''}}>{{$item->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 vertical-center-qual-badges qual-badges text-center">
                        {{Form::radio('qualbadge_display', '', isset($user->awards[$group->code]['display'])?$user->awards[$group->code]['display']:false, ['id' => 'display_' . $groupCount])}}
                    </div>
                </div>
            @endforeach

            @php
                $groupCount++;
            @endphp

        @endforeach

        @if($user->branch == 'RMA' || $user->hasPermission(['EDIT_RR'], true))
            <div class="row ribbon-group-row qual-badges">
                <div class="col-sm-10 text-center">
                    <h3>RMA Weapon Qualification Badges</h3>
                </div>
            </div>

            @foreach(App\Award::getArmyWeaponQualificationBadges() as $index => $ribbon)
                <div class="row ribbon-group-row qual-badges">
                    <div class="col-sm-1 vertical-center-qual-badges">{{Form::checkbox('select' . $groupCount . '_chk', 1, false, ['id' => 'select' . $groupCount . '_chk'])}}</div>
                    <div class="col-sm-2 text-center">
                        <img id="select{{$groupCount}}_img" class="qual-badge-hs"/>
                    </div>
                    <div class="col-sm-5 "><select name="select{{$groupCount}}" id="select{{$groupCount}}"
                                                   class="awq_group_select">
                            <option value="">{{$ribbon['group']['label']}}</option>
                            @foreach($ribbon['group']['awards'] as $item)

                                <option value='{"code": "{{$item->code}}", "img": "select{{$groupCount}}_img", "chk":  "select{{$groupCount}}_chk", "badge": "/awards/badges/{{$item->image}}"}'{{isset($user->awards[$item->code])?' selected':''}}>{{$item->name}}</option>

                            @endforeach
                        </select></div>
                </div>

                @php
                    $groupCount++;
                @endphp
            @endforeach
        @endif
    </div>

    <div class="row text-center"><h3>Individual Awards</h3></div>
    @foreach(App\Award::getLeftRibbons() as $index => $ribbon)

        @if(is_object($ribbon))
            <div class="row ribbon-row">
                <div class="col-sm-1">
                    @if(in_array($ribbon->code, $restricted) && !$hasEdit_RR)
                        @if(isset($user->awards[$ribbon->code]))
                            {{Form::hidden('ribbon[]', $ribbon->code)}}
                        @endif
                        &nbsp;@else
                        {{Form::checkbox('ribbon[]', $ribbon->code, isset($user->awards[$ribbon->code])?true:null, ['class' => 'ribbon-check', 'id' => $ribbon->code . '-select', 'data-code' => $ribbon->code])}}
                    @endif
                </div>
                <div class="col-sm-2 text-center" id="{{$ribbon->code}}">
                    @set('ribbon_image', null)
                    @if(isset($user->awards[$ribbon->code]) && file_exists(public_path('ribbons/' . $ribbon->code . '-' . $user->awards[$ribbon->code]['count'] . '.svg')))
                        @set('ribbon_image', 'ribbons/' . $ribbon->code . '-' . $user->awards[$ribbon->code]['count'] .
                        '.svg')
                    @elseif (file_exists(public_path('ribbons/' . $ribbon->code . '-1.svg')))
                        @set('ribbon_image, 'ribbons/' . $ribbon->code . '-1.svg')
                    @endif
                    @if(!is_null($ribbon_image))
                        <img src="{{asset($ribbon_image)}}" alt="{{$ribbon->name}}" class="ribbon">
                    @endif
                </div>
                <div class="col-sm-4">{{$ribbon->name}}</div>
                <div class="col-sm-1 ">
                    @if($ribbon->multiple)
                        @if(in_array($ribbon->code, $restricted) && !$hasEdit_RR)
                            {{Form::hidden($ribbon->code . '_quantity', isset($user->awards[$ribbon->code])?$user->awards[$ribbon->code]['count']:'1')}}
                        @else
                            {{Form::number($ribbon->code . '_quantity', isset($user->awards[$ribbon->code])?$user->awards[$ribbon->code]['count']:0, ['min' => 0, 'data-code' => $ribbon->code, 'data-name' => $ribbon->name, 'class' => 'ribbon-quantity'])}}
                        @endif
                    @else
                        {{Form::hidden($ribbon->code . '_quantity', '1')}}
                    @endif
                </div>
            </div>
        @else
            @if($ribbon['group']['multiple'])
                <div class="ribbon-group">
                    @foreach($ribbon['group']['awards'] as $group)

                        <div class="row ribbon-group-row">
                            <div class="col-sm-1">
                                {{Form::radio('group' . $groupCount, $group->code, isset($user->awards[$group->code])?true:null, ['class' => 'check-check', 'id' => $group->code . '-select', 'data-code' => $group->code])}}
                            </div>
                            <div class="col-sm-2 text-center" id="{{$group->code}}">
                                @set('ribbon_image', null)
                                @if(isset($user->awards[$group->code]) && file_exists(public_path('ribbons/' . $group->code . '-' . $user->awards[$group->code]['count'] . '.svg')))
                                    @set('ribbon_image', 'ribbons/' . $group->code . '-' .
                                    $user->awards[$group->code]['count'] . '.svg')
                                @elseif (file_exists(public_path('ribbons/' . $group->code . '-1.svg')))
                                    @set('ribbon_image, 'ribbons/' . $group->code . '-1.svg')
                                @endif
                                @if(!is_null($ribbon_image))
                                    <img src="{{asset($ribbon_image)}}" alt="{{$group->name}}" class="ribbon">
                                @endif
                            </div>
                            <div class="col-sm-4">{{$group->name}}</div>
                            <div class="col-sm-1 ">
                                @if($group->multiple)
                                    {{Form::number($group->code . '_quantity', isset($user->awards[$group->code])?$user->awards[$group->code]['count']:0, ['min' => 0, 'data-code' => $group->code, 'data-name' => $group->name, 'class' => 'ribbon-quantity'])}}
                                @else
                                    {{Form::hidden($group->code . '_quantity', '1')}}
                                @endif
                            </div>
                        </div>

                    @endforeach
                    <div class="row ribbon-group-row">
                        <div class="col-sm-1">
                            {{Form::radio('group' . $groupCount, '', false, ['class' => 'check-check'])}}
                        </div>
                        <div class="col-sm-2 text-center">&nbsp;</div>
                        <div class="col-sm-4 ">None of the above</div>
                    </div>
                </div>
            @else
                <div class="row ribbon-row">
                    <div class="col-sm-1">{{Form::checkbox('select' . $groupCount . '_chk', 1, false, ['id' => 'select' . $groupCount . '_chk'])}}</div>
                    <div class="col-sm-2 text-center">
                        <img id="select{{$groupCount}}_img" class="ribbon"/>
                    </div>
                    <div class="col-sm-5 "><select name="select{{$groupCount}}" id="select{{$groupCount}}"
                                                   class="ribbon_group_select">
                            <option value="">{{$ribbon['group']['label']}}</option>
                            @foreach($ribbon['group']['awards'] as $item)
                                {{--                                    @if(file_exists(public_path('ribbons/' . $item->code . '-1.svg')))--}}
                                <option value='{"code": "{{$item->code}}", "img": "select{{$groupCount}}_img", "chk":  "select{{$groupCount}}_chk", "imgbase": "/ribbons/"}'{{isset($user->awards[$item->code])?' selected':''}}>{{$item->name}}</option>
                                {{--@endif--}}
                            @endforeach
                        </select></div>
                </div>
            @endif

            @php
                $groupCount++;
            @endphp
        @endif
    @endforeach

    <div class="row text-left">
        <p><input type="checkbox" id="ack"> I acknowledge that awards entered into the MEDUSA System are not
            private,
            and are subject to review. Members knowingly holding themselves out as having awards they have not been
            given may be subject to discipline. Use of the award system is considered acknowledgment of this notice.
        </p>
        {{Form::submit('Save', ['class' => 'btn btn-success', 'disabled' => true])}}
    </div>
    {{Form::close()}}
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#ack').change(function () {
                if (this.checked) {
                    $('.btn').prop("disabled", false);
                } else {
                    $('.btn').prop("disabled", true);
                }
            });

            $('#unitPatch').selectize({
                create: false,
                hideSelected: true,
                closeAfterSelect: true,
                render: {
                    option: function (item, escape) {
                        return '<div class="ribbon-dropdown"><span><img src="/' + item.value + '"></span></div>';
                    },
                },
                onChange: function (value) {
                    $('#patchImage').attr('src', '/' + value);
                }
            });

            $('.ribbon_group_select').selectize({
                create: false,
                hideSelected: true,
                closeAfterSelect: true,
                render: {
                    option: function (item, escape) {
                        var ribbon = JSON.parse(item.value);

                        return '<div class="ribbon-dropdown"><span><img src="' + ribbon.imgbase + ribbon.code + '-1.svg" class="ribbon"></span><span> ' + item.text + '</span></div>';
                    },
                },
                onChange: function (value) {
                    var ribbon = JSON.parse(value);

                    $('#' + ribbon.img).attr('src', ribbon.imgbase + ribbon.code + '-1.svg');
                    $('#' + ribbon.chk).val(ribbon.code);

                    if (typeof ribbon.display !== 'undefined') {
                        $('#' + ribbon.display).val(ribbon.code);
                    }
                }
            });

            $('.awq_group_select').selectize({
                create: false,
                hideSelected: true,
                closeAfterSelect: true,
                render: {
                    option: function (item, escape) {
                        var ribbon = JSON.parse(item.value);

                        return '<div class="ribbon-dropdown"><span><img src="' + ribbon.badge + '"></span><span> ' + item.text + '</span></div>';
                    },
                },
                onChange: function (value) {
                    var ribbon = JSON.parse(value);

                    $('#' + ribbon.img).attr('src', ribbon.badge);
                    $('#' + ribbon.chk).val(ribbon.code);

                    if (typeof ribbon.display !== 'undefined') {
                        $('#' + ribbon.display).val(ribbon.code);
                    }
                }
            });

            var ids = [];
            $('.ribbon_group_select').each(function () {
                var $this = $(this);
                var id = $this.attr('id');
                if (typeof id !== 'undefined') {
                    ids.push(id);
                }
            })

            $.each(ids, function (i, id) {
                var $select = $('#' + id).selectize();
                var control = $select[0].selectize;
                if (control.getValue() !== '') {
                    var ribbon = JSON.parse(control.getValue());

                    if (typeof ribbon.img !== 'undefined') {
                        $('#' + ribbon.img).attr('src', ribbon.imgbase + ribbon.code + '-1.svg');
                        $('#' + ribbon.chk).attr('checked', true);
                        $('#' + ribbon.chk).val(ribbon.code);

                        if (typeof ribbon.display !== 'undefined') {
                            $('#' + ribbon.display).val(ribbon.code);
                        }
                    }
                } else {
                    var options = control.options;
                    var ribbon = JSON.parse(options[Object.keys(options)[Object.keys(options).length - 1]]['value']);
                    $('#' + ribbon.img).attr('src', ribbon.imgbase + ribbon.code + '-1.svg');
                }

            });

            var ids = [];
            $('.awq_group_select').each(function () {
                var $this = $(this);
                var id = $this.attr('id');
                if (typeof id !== 'undefined') {
                    ids.push(id);
                }
            })

            $.each(ids, function (i, id) {
                var $select = $('#' + id).selectize();
                var control = $select[0].selectize;
                if (control.getValue() !== '') {
                    var ribbon = JSON.parse(control.getValue());

                    if (typeof ribbon.img !== 'undefined') {
                        $('#' + ribbon.img).attr('src', ribbon.badge);
                        $('#' + ribbon.chk).attr('checked', true);
                        $('#' + ribbon.chk).val(ribbon.code);

                        if (typeof ribbon.display !== 'undefined') {
                            $('#' + ribbon.display).val(ribbon.code);
                        }
                    }
                } else {
                    var options = control.options;
                    var ribbon = JSON.parse(options[Object.keys(options)[Object.keys(options).length - 1]]['value']);
                    $('#' + ribbon.img).attr('src', ribbon.badge);
                }

            });

            $('.ribbon-quantity').on('change', function () {
                var el = $(this);
                var ribbonCode = el.data('code');
                var ribbonName = el.data('name');
                var ribbonCount = el.val();
                if (ribbonCount >= 1) {
                    $('#' + ribbonCode + '-select').prop('checked', true);
                } else {
                    $('#' + ribbonCode + '-select').prop('checked', false);
                }

                updateRibbon(ribbonCode, ribbonCount, ribbonName);
            });

            $('.ribbon-check').on('click', function () {
                var el = $(this);

                validateSelection(el);
            });

            $('.check-check').on('change', function () {
                var el = $(this);

                validateSelection(el);

                $('input[name="' + el.prop('name') + '"]').each(function () {
                    var item = $(this);
                    if (!item.prop('checked') === true) {
                        $('input[name="' + item.data('code') + '_quantity"]').val(0);
                        updateRibbon(item.data('code'), 0, $('input[name="' + item.data('code') + '_quantity"]').data('name'));
                    }
                });
            });

            function validateSelection(el) {
                var isChecked = el.prop('checked');
                var ribbonCode = el.data('code');

                if (isChecked && $('input[name="' + ribbonCode + '_quantity"]').val() < 1) {
                    $('input[name="' + ribbonCode + '_quantity"]').val(1);
                } else {
                    $('input[name="' + ribbonCode + '_quantity"]').val(0);
                    updateRibbon(ribbonCode, 0, $('input[name="' + ribbonCode + '_quantity"]').data('name'));
                }
            }

            function updateRibbon(ribbonCode, ribbonCount, ribbonName) {
                $.ajax({
                    url: "/api/awards/get_ribbon_image/" + ribbonCode + "/" + ribbonCount + "/" + encodeURIComponent(ribbonName),
                    type: "GET",
                    dataType: "html",
                    success: function (data) {
                        $('#' + ribbonCode).html(data);
                    }
                });
            }
        });
    </script>
@stop

