@extends('layout')

@section('pageTitle')
    Billets List
@stop

@section('content')
    <div><h3 class="trmn">Billet List</h3></div>

    <table class="trmnTableWithActions compact row-border">
        <thead>
        <tr>
            <th>Billet</th>
            <th># Assigned</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Billet::all() as $billet)
            <?php
            $count = $billet->getAssignedCount();
            ?>
            <tr>
                <td>{!! $billet->billet_name !!}</td>
                <td>{!! $count !!}</td>
                <td><a href="{!!route('billet.edit', [$billet->id])!!}" class="tiny fa fa-pencil green size-24"
                       data-toggle="tooltip" title="Edit Billet"></a>
                    @if($count == 0)
                        <a href="javascript:deleteUser('{!!$billet->id!!}','{!!$billet->billet_name!!}');"
                           class="tiny fa fa-close red size-24"></a>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Billet</th>
            <th># Assigned</th>
            <th></th>
        </tr>
        </tfoot>
    </table>

@stop
@section('scriptFooter')
    <script type="text/javascript">
        function deleteUser(id, name) {
            if (confirm('Delete the ' + name + ' billet?')) {
                jQuery.ajax({
                    method: "DELETE",
                    url: '/billet/' + id,
                }).done(function (affectedRows) {
                    //if something was deleted, we redirect the user to the users page, and automatically the user that he deleted will disappear
                    if (affectedRows > 0) {
                        window.location = '/billet';
                    }
                });
            }
        }
    </script>
@stop