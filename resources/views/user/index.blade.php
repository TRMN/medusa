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
            <li role="presentation" class="active memberlist-tab"><a href="#members-1" role="tab"
                                                                    data-toggle="pill">RMN</a></li>
            <li role="presentation" class="memberlist-tab"><a href="#members-2" role="tab" data-toggle="pill">RMMC</a>
            </li>
            <li role="presentation" class="memberlist-tab"><a href="#members-3" role="tab" data-toggle="pill">RMA</a></li>
            <li role="presentation" class="memberlist-tab"><a href="#members-4" role="tab" data-toggle="pill">GSN</a></li>
            <li role="presentation" class="memberlist-tab"><a href="#members-5" role="tab" data-toggle="pill">RHN</a></li>
            <li role="presentation" class="memberlist-tab"><a href="#members-6" role="tab" data-toggle="pill">IAN</a></li>
            <li role="presentation" class="memberlist-tab"><a href="#members-7" role="tab" data-toggle="pill">SFS</a></li>
            <li role="presentation" class="memberlist-tab"><a href="#members-8" role="tab" data-toggle="pill">Civilian</a>
            </li>
            <li role="presentation" class="memberlist-tab"><a href="#members-9" role="tab"
                                                             data-toggle="pill">Intelligence</a></li>
            <li role="presentation class=" class="memberlist-tab"><a href="#inactive">Inactive</a></li>
            @if($permsObj->hasPermissions('ALL_PERMS') === true)
                <li role="presentation" class="memberlist-tab"><a href="#suspended" role="tab" data-toggle="pill">Suspended</a>
                </li>
                <li role="presentation" class="memberlist-tab"><a href="#expelled" role="tab"
                                                                 data-toggle="pill">Expelled</a></li>
            @endif
        </ul>
        <br/>
        <div id="members-1" role="tabpanel" class="tab-pane active">
            @include('user.partials.byBranch', ['branch' => 'RMN'])
        </div>

        <div id="inactive" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'Inactive'])
        </div>

        @if($permsObj->hasPermissions('ALL_PERMS') === true)
            <div id="suspended" role="tabpanel" class="tab-pane">
                @include('user.partials.byBranch', ['branch' => 'Suspended'])
            </div>

            <div id="expelled" role="tabpanel" class="tab-pane">
                @include('user.partials.byBranch', ['branch' => 'Expelled'])
            </div>
        @endif

        <div id="members-9" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'INTEL'])
        </div>

        <div id="members-8" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'CIVIL'])
        </div>

        <div id="members-7" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'SFS'])
        </div>

        <div id="members-6" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'IAN'])
        </div>

        <div id="members-5" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'RHN'])
        </div>

        <div id="members-4" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'GSN'])
        </div>

        <div id="members-3" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'RMA'])
        </div>

        <div id="members-2" role="tabpanel" class="tab-pane">
            @include('user.partials.byBranch', ['branch' => 'RMMC'])
        </div>

    </div>
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $(document).ready(function ($) {
            @foreach(['RMN', 'RMMC', 'RMA', 'GSN', 'RHN', 'IAN', 'SFS', 'CIVIL', 'INTEL', 'Inactive', 'Suspended', 'Expelled'] as $branch)
            $('.trmnUserTable-{{$branch}}').DataTable({
                "autoWidth": false,
                "pageLength": 25,
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
            @endforeach
        });
    </script>
@stop