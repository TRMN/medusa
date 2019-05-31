@extends('layout')

@section('pageTitle')
    {!! $title !!}
@stop

@section('content')
    <div><h3 class="trmn">{!! $title !!}</h3></div>
    <div>Active Members: {!!$totalMembers!!} Enlisted: {!!$totalEnlisted!!} Officer: {!!$totalOfficer!!} Flag
        Officer: {!!$totalFlagOfficer!!} Civilian: {!!$totalCivilian!!}</div>
    <br/>
    <div id="members">
        <ul class="nav nav-pills" role="tablist">
            @foreach(\App\Models\MedusaConfig::get('memberlist.branches') as $branchName)
                <li role="presentation" class="memberlist-tab{{$loop->first?' active':''}}"><a
                            href="#members-{{$loop->iteration}}" role="tab" data-toggle="pill">{{$branchName}}</a>
                </li>
            @endforeach
            <li role="presentation class=" class="memberlist-tab"><a href="#inactive">Inactive</a></li>
            @if($permsObj->hasPermissions('ALL_PERMS') === true)
                <li role="presentation" class="memberlist-tab"><a href="#suspended" role="tab" data-toggle="pill">Suspended</a>
                </li>
                <li role="presentation" class="memberlist-tab"><a href="#expelled" role="tab"
                                                                  data-toggle="pill">Expelled</a></li>
            @endif
        </ul>
        <br/>
        @foreach(\App\Models\MedusaConfig::get('memberlist.branches') as $branch => $branchName)
            <div id="members-{{$loop->iteration}}" role="tabpanel" class="tab-pane hidden{{$loop->first?' active':''}}">
                @include('user.partials.byBranch', ['branch' => $branch])
            </div>
        @endforeach


        <div id="inactive" role="tabpanel" class="tab-pane hidden">
            @include('user.partials.byBranch', ['branch' => 'Inactive'])
        </div>

        @if($permsObj->hasPermissions('ALL_PERMS') === true)
            <div id="suspended" role="tabpanel" class="tab-pane hidden">
                @include('user.partials.byBranch', ['branch' => 'Suspended'])
            </div>

            <div id="expelled" role="tabpanel" class="tab-pane hidden">
                @include('user.partials.byBranch', ['branch' => 'Expelled'])
            </div>
        @endif
    </div>
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(document).ready(function ($) {
            @foreach(array_merge(\App\Models\MedusaConfig::get('memberlist.branches'), ['Inactive' => 'Inactive', 'Suspended' => 'Suspended', 'Expelled' => 'Expelled']) as $branch => $branchName)
            $('.trmnUserTable-{{$branch}}').DataTable({
                "autoWidth": false,
                "pageLength": 10,
                "serverSide": true,
                "ajax": {
                    url: '/users/list/{{$branch}}',
                    type: 'post'
                },
                "columnDefs": [{
                    "targets": [0, 2, 6, 8],
                    "orderable": false,
                    "searchable": false
                }],
                "order": [[3, 'asc']],
                "$UI": true
            });

            $('.trmnUserTable-{{$branch}}').on('draw.dt', function() {
                $('#right').height(240 + $('.trmnUserTable-{{$branch}}').height());

                if ($('#right').height() < $('#left').height()) {
                    $('#right').height($('#left').height());
                }
            });
            @endforeach

            @foreach(array_merge(\App\Models\MedusaConfig::get('memberlist.branches'), ['Inactive' => 'Inactive', 'Suspended' => 'Suspended', 'Expelled' => 'Expelled']) as $branch => $branchName)
            @if(!in_array($branch, ['Inactive', 'Suspended', 'Expelled']))
            $('#members-{{$loop->iteration}}').removeClass('hidden');
            @else
            $('#{{strtolower($branch)}}').removeClass('hidden');
            @endif
            @endforeach

        });
    </script>
@stop