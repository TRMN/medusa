@extends('layout')

@section('pageTitle')
Chapter Types
@stop

@section('content')
    <div><h3 class="trmn">Chapter Types</h3></div>

    <table class="trmnTableWithActions compact row-border">
        <thead>
            <tr>
                <th>Description</th>
                <th>Type</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach(App\Type::orderBy('chapter_description', 'asc')->get() as $type)
            <tr>
                <td>{!! $type->chapter_description !!}</td>
                <td>{!! $type->chapter_type !!}</td>
                <td><a class="tiny fi-pencil green size-24" href="{!! route('type.edit', [ $type->_id ]) !!}" data-toggle="tooltip" title="Edit Chapter Type"></a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Description</th>
                <th>Type</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

@stop
