@extends('layout')

@section('pageTitle')
Users
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Member ID</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach( $users as $user )
                <tr>
                    <td><a href="{{ route('user.show' , [$user->_id]) }}">{{{ $user->first_name }}}{{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}} {{{ $user->last_name }}}</a></td>
                    <td>{{{ $user->member_id }}}</td>
                    <td>{{{ $user->email_address }}}</td>
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
