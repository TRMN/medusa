@extends('layout')

@section('pageTitle')
    {{ $title }}
@stop

@section('content')
    <div><h3 class="trmn">{{ $title }}</h3></div>
            <table id="reviewApplications" class="compact row-border stripe">
                <thead>
                <tr>
                    <th>Name</th>
                    <th width="10%">Member ID</th>
                    <th width="15%">Application Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach( $users as $user )
                        <tr>
                            <td><a href="{{{ route('user.show', [$user->_id]) }}}">{{{ $user->last_name }}}, {{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}}</a>
                            </td>
                            <td width="10%">{{{ $user->member_id }}}</td>
                            <td width="15%">{{{ $user->application_date }}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th width="10%">Member ID</th>
                    <th width="15%">Application Date</th>
                </tr>
                </tfoot>
            </table>
@stop
