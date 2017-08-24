@extends('layout')

@section('pageTitle')
    Exam List
@stop

@section('content')
    <div><h3 class="trmn">Exam List</h3></div>

    <table class="trmnTableWithActions compact row-border">
        <thead>
        <tr>
            <th>Exam ID</th>
            <th>Exam Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach(App\ExamList::all() as $exam)
            <tr>
                <td>{!! $exam->exam_id !!} @if($exam->enabled === false) (Disabled) @endif</td>
                <td>{!! $exam->name !!}</td>
                <td><a href="{!!route('exam.edit', [$exam->id])!!}" class="tiny fa fa-pencil green size-24"
                       data-toggle="tooltip" title="Edit Exam"></a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Exam ID</th>
            <th>Exam Description</th>
            <th></th>
        </tr>
        </tfoot>
    </table>

@stop