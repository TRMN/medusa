@extends('layout')

@section('pageTitle')
    Ribbon Rack Builder
@stop

@section('content')
    <div class="row">
        <h1 class="text-center">Ribbon Rack Builder
            for {!!  $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}</h1>

        <p>Currently, the Ribbon Rack Builder only supports RMN/RMMC ribbons. As the artwork becomes
            available for RMA, GSN, RHN and IAN ribbons, they will be added.</p>

        <p>Once you save your ribbon rack, it will be record in your MEDUSA record and displayed on your Service Record.
            There will be a link under your ribbon rack that will show you the HTML required to embed your ribbon rack
            in another website.</p>

        <p>Please select your awards from the list below, then click "Save". If an award can be awarded more than once,
            you will be able to select the number of times you have received the award.</p>
    </div>

    {!! Form::open(array('route' => 'saverack')) !!}
    @foreach(App\Award::getLeftSleeve() as $badge)
        @if(file_exists(public_path('images/' . $badge->code . '.svg')))
            <div class="row ribbon-row">
                <div class="columns small-1">
                    {!!Form::checkbox('ribbon[]', $badge->code, isset($user->awards[$badge->code])?true:null)!!}
                </div>
                <div class="columns small-2 text-center">
                    <img src="{!!asset('images/' . $badge->code . '.svg')!!}" alt="{!!$badge->name!!}">
                </div>
                <div class="columns small-5 end">
                    @if($badge->multiple)
                        {!!Form::select($badge->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$badge->code])?$user->awards[$badge->code]['count']:1)!!}
                    @else
                        {!!Form::hidden($badge->code . '_quantity', '1')!!}
                    @endif
                </div>
            </div>
        @endif
    @endforeach
    <br clear="both"/>
    <div class="row text-center"><h3>Unit Patch</h3></div>
    <div class="ribbon-group">
        <div class="row patch-row">
            <div class="columns small-1">&nbsp;</div>
            <div class="columns small-2 text-center">
                <img src="{{ empty($user->unitPatchPath)? '/' . current(array_flip(array_slice($unitPatchPaths, 0, 1))) : '/' . $user->unitPatchPath}}"
                     id="patchImage"/><br/>
                {!! Form::select('unitPatch', $unitPatchPaths, empty($user->unitPatchPath)? null : $user->unitPatchPath, ['id' => 'unitPatch']) !!}
            </div>
            <div class="columns small-5 end"></div>
        </div>
    </div>
    <br clear="both"/>

    <div class="row text-center"><h3>Award Stripes</h3></div>
    <div class="ribbon-group">
        @foreach(App\Award::getRightSleeve() as $badge)
            @if(file_exists(public_path('awards/stripes/' . $badge->code . '-1.svg')))
                <div class="row ribbon-group-row">
                    <div class="columns small-1">
                        {!!Form::checkbox('ribbon[]', $badge->code, isset($user->awards[$badge->code])?true:null)!!}
                    </div>
                    <div class="columns small-2 text-center">
                        <img src="{!!asset('awards/stripes/' . $badge->code . '-1.svg')!!}" alt="{!!$badge->name!!}">
                    </div>
                    <div class="columns small-4"><br/><br/>{!!$badge->name!!}</div>
                    <div class="columns small-1 end">
                        @if($badge->multiple)
                            {!!Form::select($badge->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$badge->code])?$user->awards[$badge->code]['count']:1)!!}
                        @else
                            {!!Form::hidden($badge->code . '_quantity', '1')!!}
                        @endif
                    </div>
                </div>
                <br clear="both"/>
            @endif
        @endforeach
    </div>

    <div class="row text-center"><h3>Unit Citations</h3></div>
    <div class="ribbon-group">
        @foreach(App\Award::getRightRibbons() as $ribbon)
            @if(file_exists(public_path('ribbons/' . $ribbon->code . '-1.svg')))
                <div class="row ribbon-group-row">
                    <div class="columns small-1">
                        {!!Form::checkbox('ribbon[]', $ribbon->code, isset($user->awards[$ribbon->code])?true:null)!!}
                    </div>
                    <div class="columns small-2 text-center">
                        <img src="{!!asset('ribbons/' . $ribbon->code . '-1.svg')!!}" alt="{!!$ribbon->name!!}"
                             class="ribbon">
                    </div>
                    <div class="columns small-4">{!!$ribbon->name!!}</div>
                    <div class="columns small-1 end">
                        @if($ribbon->multiple)
                            {!!Form::select($ribbon->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$ribbon->code])?$user->awards[$ribbon->code]['count']:1)!!}
                        @else
                            {!!Form::hidden($ribbon->code . '_quantity', '1')!!}
                        @endif
                    </div>
                </div>
                <br clear="both"/>
            @endif
        @endforeach
    </div>

    <div class="row text-center"><h3>Qualification Badges</h3></div>
    @foreach(App\Award::getTopBadges() as $index => $badge)
        @if(is_object($badge))
            @if(file_exists(public_path('awards/badges/' . $badge->code . '-1.svg')))
                <div class="row ribbon-row">
                    <div class="columns small-1">
                        {!!Form::checkbox('ribbon[]', $badge->code, isset($user->awards[$badge->code])?true:null)!!}
                    </div>
                    <div class="columns small-2 text-center">
                        <img src="{!!asset('awards/badges/' . $badge->code . '-1.svg')!!}" alt="{!!$badge->name!!}">
                    </div>
                    <div class="columns small-4">{!!$badge->name!!}</div>
                    <div class="columns small-1 end">
                        @if($badge->multiple)
                            {!!Form::select($badge->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$badge->code])?$user->awards[$badge->code]['count']:1)!!}
                        @else
                            {!!Form::hidden($badge->code . '_quantity', '1')!!}
                        @endif
                    </div>
                </div>
            @endif
        @else
            <div class="ribbon-group">
                @foreach($badge['group']['awards'] as $group)
                    @if(file_exists(public_path('awards/badges/' . $group->code . '-1.svg')))
                        <div class="row ribbon-group-row">
                            <div class="columns small-1">
                                {!!Form::radio('group' . $index, $group->code, isset($user->awards[$group->code])?true:null)!!}
                            </div>
                            <div class="columns small-2 text-center">
                                <img src="{!!asset('awards/badges/' . $group->code . '-1.svg')!!}"
                                     alt="{!!$group->name!!}">
                            </div>
                            <div class="columns small-4">{!!$group->name!!}</div>
                            <div class="columns small-1 end">
                                @if($group->multiple)
                                    {!!Form::select($group->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$group->code])?$user->awards[$group->code]['count']:1)!!}
                                @else
                                    {!!Form::hidden($group->code . '_quantity', '1')!!}
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="row ribbon-group-row">
                    <div class="columns small-1">
                        {!!Form::radio('group' . $index, null)!!}
                    </div>
                    <div class="columns small-2 text-center">&nbsp;</div>
                    <div class="columns small-4 end">None of the above</div>
                </div>
            </div>
        @endif
    @endforeach

    <div class="row text-center"><h3>Individual Awards</h3></div>
    @foreach(App\Award::getLeftRibbons() as $index => $ribbon)
        @if(is_object($ribbon))
            @if(file_exists(public_path('ribbons/' . $ribbon->code . '-1.svg')))
                <div class="row ribbon-row">
                    <div class="columns small-1">
                        {!!Form::checkbox('ribbon[]', $ribbon->code, isset($user->awards[$ribbon->code])?true:null)!!}
                    </div>
                    <div class="columns small-2 text-center">
                        <img src="{!!asset('ribbons/' . $ribbon->code . '-1.svg')!!}" alt="{!!$ribbon->name!!}"
                             class="ribbon">
                    </div>
                    <div class="columns small-4">{!!$ribbon->name!!}</div>
                    <div class="columns small-1 end">
                        @if($ribbon->multiple)
                            {!!Form::select($ribbon->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$ribbon->code])?$user->awards[$ribbon->code]['count']:1)!!}
                        @else
                            {!!Form::hidden($ribbon->code . '_quantity', '1')!!}
                        @endif
                    </div>
                </div>
            @endif
        @else
            @if($ribbon['group']['multiple'])
                <div class="ribbon-group">
                    @foreach($ribbon['group']['awards'] as $group)
                        @if(file_exists(public_path('ribbons/' . $group->code . '-1.svg')))
                            <div class="row ribbon-group-row">
                                <div class="columns small-1">
                                    {!!Form::radio('group' . $index, $group->code, isset($user->awards[$group->code])?true:null)!!}
                                </div>
                                <div class="columns small-2 text-center">
                                    <img src="{!!asset('ribbons/' . $group->code . '-1.svg')!!}"
                                         alt="{!!$group->name!!}" class="ribbon">
                                </div>
                                <div class="columns small-4">{!!$group->name!!}</div>
                                <div class="columns small-1 end">
                                    @if($group->multiple)
                                        {!!Form::select($group->code . '_quantity', [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5'], isset($user->awards[$group->code])?$user->awards[$group->code]['count']:1)!!}
                                    @else
                                        {!!Form::hidden($group->code . '_quantity', '1')!!}
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="row ribbon-group-row">
                        <div class="columns small-1">
                            {!!Form::radio('group' . $index, null)!!}
                        </div>
                        <div class="columns small-2 text-center">&nbsp;</div>
                        <div class="columns small-4 end">None of the above</div>
                    </div>
                </div>
            @else
                <div class="row ribbon-row">
                    <div class="columns small-1">{{Form::checkbox('select' . $index . '_chk', 1, false, ['id' => 'select' . $index . '_chk'])}}</div>
                    <div class="columns small-2 text-center">
                        <img id="select{{$index}}_img" class="ribbon"/>
                    </div>
                    <div class="columns small-5 end"><select name="select{{$index}}" id="select{{$index}}"
                                                             class="ribbon_group_select">
                            <option value="">{{$ribbon['group']['label']}}</option>
                            @foreach($ribbon['group']['awards'] as $item)
                                @if(file_exists(public_path('ribbons/' . $item->code . '-1.svg')))
                                    <option value='{"code": "{{$item->code}}", "img": "select{{$index}}_img", "chk":  "select{{$index}}_chk"}'{{isset($user->awards[$item->code])?' selected':''}}>{{$item->name}}</option>
                                @endif
                            @endforeach
                        </select></div>
                </div>

            @endif
        @endif
    @endforeach
    <div class="row text-left">
        <p><input type="checkbox" id="ack"> I acknowledge that awards entered into the MEDUSA System are not private,
            and are subject to review. Members knowingly holding themselves out as having awards they have not been
            given may be subject to discipline. Use of the award system is considered acknowledgment of this notice.</p>
        {!!Form::submit('Save', ['class' => 'button', 'disabled' => true])!!}
    </div>
    {!!Form::close()!!}
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#ack').change(function () {
                if (this.checked) {
                    $('.button').prop("disabled", false);
                } else {
                    $('.button').prop("disabled", true);
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

                        return '<div class="ribbon-dropdown"><span><img src="/ribbons/' + ribbon.code + '-1.svg" class="ribbon"></span><span> ' + item.text + '</span></div>';
                    },
                },
                onChange: function (value) {
                    var ribbon = JSON.parse(value);

                    $('#' + ribbon.img).attr('src', '/ribbons/' + ribbon.code + '-1.svg');
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
                        $('#' + ribbon.img).attr('src', '/ribbons/' + ribbon.code + '-1.svg');
                        $('#' + ribbon.chk).attr('checked', true);
                    }
                } else {
                    var options = control.options;
                    var ribbon = JSON.parse(options[Object.keys(options)[Object.keys(options).length - 1]]['value']);
                    $('#' + ribbon.img).attr('src', '/ribbons/' + ribbon.code + '-1.svg');
                }

            });
        });
    </script>
@stop

