@extends('layout')

@section('pageTitle')
Chapter Types
@stop

@section('content')
    <div><h3 class="trmn">Chapter Types</h3></div>

    <table id="billetList" class="compact row-border">
        <thead>
            <tr>
                <th>Type</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        @foreach(Type::all() as $type)
            <tr>
                <td>{{ $type->chapter_type }}</td>
                <td>{{ $type->chapter_description }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Type</th>
                <th>Description</th>
            </tr>
        </tfoot>
    </table>

@stop
