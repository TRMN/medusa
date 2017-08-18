@extends('layout')

@section('pageTitle')
    Configuration Settings
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 Incised901Light">
            <h1>Configuration Settings</h1>
        </div>
    </div>

    @if(count(\App\MedusaConfig::all()))
        <table class="trmnTableWithActions compact row-border" id="config-table">
            <thead>
            <tr>
                <th>Configuration Key</th>
                <th>Configuration Value</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\MedusaConfig::all() as $item)
                <tr>
                    <td class="border-right">{!! $item->key !!}</td>
                    <td class="border-right">@if(is_array($item->value)) <pre class="json"> @endif
                        {!! is_array($item->value)?json_encode($item->value):$item->value !!}
                        @if(is_array($item->value)) </pre> @endif
                    </td>
                    <td><a href="{!!route('config.edit', [$item->id])!!}" class="tiny fi-pencil green size-24"
                           data-toggle="tooltip" title="Edit Config"></a>
                        <a href="javascript:deleteConfig('{!!$item->id!!}','{!!$item->key!!}');"
                           class="tiny fi-x red size-24"></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Configuration Key</th>
                <th>Configuration Value</th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    @else
        <div class="row">
            <div class=" col-sm-12 Incised901Light"><h3>There are no configuration settings stored in the
                    database.</h3></div>
        </div>
    @endif

@stop

@section('scriptFooter')
    <script type="text/javascript">
        function deleteConfig(id, name) {
            if (confirm('Delete ' + name + '?')) {
                jQuery.ajax({
                    method: "DELETE",
                    url: '/config/' + id,
                }).done(function (affectedRows) {
                    //if something was deleted, we redirect the user to the users page, and automatically the user that he deleted will disappear
                    if (affectedRows > 0) {
                        window.location = '/config';
                    }
                });
            }
        }

        $(document).ready(function () {
            $('.json').each(function (i, el) {
                var elm = $(el);
                elm.html(JSON.stringify(JSON.parse(elm.html()), undefined, 4));
            });
        });
    </script>
@stop