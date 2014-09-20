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
                    <td>{{{ $user->first_name }}} {{{ $user->last_name }}}</td>
                    <td>{{{ $user->member_id }}}</td>
                    <td>{{{ $user->email }}}</td>
                    <td><a class="btn btn-info" href="{{ route('user.edit', [ $user->id ]) }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-info" href="{{ route('user.create') }}">Create User</a>
@stop