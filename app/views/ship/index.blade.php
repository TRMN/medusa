@extends('layout')

@section('pageTitle')
Ships
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th># Members</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach( $ships as $ship )
                <tr>
                    <td>{{{ $ship->chapter()->title }}}</td>
                    <td></td>
                    <td>
                        <a class="button tiny" href="{{ route('ship.edit', [ $ship->id ]) }}">Edit</a> 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-info" href="{{ route('ship.create') }}">Create Ship</a>
@stop
