@extends('layout')

@section('pageTitle')
Users
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="name">Name</th>
                <th class="memberid">Member ID</th>
                <th class="email">Email</th>
                <th class="branch">Branch</th>
                <th class="chapter">Chapter</th>
                <th class="actions"></th>
            </tr>
        </thead>
        <tbody>
            @foreach( $users as $user )
                <tr>
                    <td><a href="{{ route('user.show' , [$user->_id]) }}">{{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}</a></td>
                    <td>{{{ $user->member_id }}}</td>
                    <td>{{{ $user->email_address }}}</td>
                    <td>{{{ $user->branch }}}</td>
                    <td>
                        @if($user->primary_assignment_name != 'No assignment')
                            <a href="/chapter/{{{ $user->primary_assignment }}}">{{{ $user->primary_assignment_name }}}</a>
                        @else
                            No assignment
                        @endif
                    </td>

                    <td>
                        <a class="btn" href="{{ route('user.edit', [ $user->_id ]) }}">Edit</a>&nbsp;&nbsp;
                        <a class="btn" href="{{ route('user.destroy', [ $user->_id]) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-info" href="{{ route('user.create') }}">Create User</a>
@stop
