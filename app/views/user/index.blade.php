@extends('layout')

@section('pageTitle')
    {{ $title }}
@stop

@section('content')
    <div><h3 class="trmn">{{ $title }}</h3></div>
    <div>Active Members: {{$totalMembers}} Enlisted: {{$totalEnlisted}} Officer: {{$totalOfficer}} Flag
        Officer: {{$totalFlagOfficer}} Civilian: {{$totalCivilian}}</div>
    <div id="members">
        <ul>
            <li><a href="#members-1">RMN</a></li>
            <li><a href="#members-2">RMMC</a></li>
            <li><a href="#members-3">RMA</a></li>
            <li><a href="#members-4">GSN</a></li>
            <li><a href="#members-5">RHN</a></li>
            <li><a href="#members-6">IAN</a></li>
            <li><a href="#members-7">SFS</a></li>
            <li><a href="#members-8">Civilian</a></li>
            <li><a href="#members-9">Intelligence</a></li>
            <li><a href="#inactive">Inactive</a></li>
            @if($permsObj->hasPermissions('ALL_PERMS') === true)
                <li><a href="#suspended">Suspended</a></li>
                <li><a href="#expelled">Expelled</a></li>
            @endif
        </ul>
        <div id="members-1">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'RMN'])
        </div>
        <div id="inactive">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $otherThanActive, 'branch' => 'Inactive'])
        </div>
        @if($permsObj->hasPermissions('ALL_PERMS') === true)
            <div id="suspended">
                @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $otherThanActive, 'branch' => 'Suspended'])
            </div>
            <div id="expelled">
                @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $otherThanActive, 'branch' => 'Expelled'])
            </div>
        @endif
        <div id="members-9">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'INTEL'])
        </div>
        <div id="members-8">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'CIVIL'])
        </div>
        <div id="members-7">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'SFS'])
        </div>
        <div id="members-6">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'IAN'])
        </div>
        <div id="members-5">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'RHN'])
        </div>
        <div id="members-4">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'GSN'])
        </div>
        <div id="members-3">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'RMA'])
        </div>
        <div id="members-2">
            @include('user.partials.byBranch', ['permsObj' => $permsObj, 'users' => $users, 'branch' => 'RMMC'])
        </div>

    </div>
@stop
