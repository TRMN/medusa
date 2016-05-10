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
            <th>Exam Name</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach(Exams::all() as $exam)
            <tr>
                <td>{{ $exam->exam_id }}</td>
                <td>{{ $exam->exam_name }}</td>
                <td><a href="{{route('exams.edit', [$exam->id])}}" class="tiny fi-pencil green size-24"
                       title="Edit Exam"></a>
                    @if($count == 0)
                        <a href="javascript:deleteUser('{{$exam->id}}','{{$exam->exam_name}}');"
                           class="tiny fi-x red size-24"></a>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Exam ID</th>
            <th>Exam Name</th>
            <th></th>
        </tr>
        </tfoot>
    </table>

@stop
@section('scriptFooter')
    <script type="text/javascript">
        function deleteUser(id, name) {
            if (confirm('Delete the ' + name + ' examt?')) {
                jQuery.ajax({
                    method: "DELETE",
                    url: '/exam/' + id,
                }).done(function (affectedRows) {
                    //if something was deleted, we redirect the user to the users page, and automatically the user that he deleted will disappear
                    if (affectedRows > 0) {
                        window.location = '/exam';
                    }
                });
            }
        }
    </script>
@stop