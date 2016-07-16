@extends('layout')

@section('pageTitle')
    OAuth Clients
@stop

@section('content')
    <div><h3 class="trmn">OAuth Clients</h3></div>

    <table class="trmnTableWithActions compact row-border">
        <thead>
        <tr>
            <th>Client ID</th>
            <th>Client Name</th>
            <th width="50px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->client_id }}</td>
                <td>{{ $client->client_name }}</td>
                <td><a href="{{route('oauthclient.edit', [$client->id])}}" class="tiny fi-pencil green size-24"
                       title="Edit OAuth Client"></a>
                    <a href="javascript:deleteClient('{{$client->id}}','{{$client->client_name}}');"
                       class="tiny fi-x red size-24"></a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Client ID</th>
            <th>Client Name</th>
            <th></th>
        </tr>
        </tfoot>
    </table>

@stop
@section('scriptFooter')
    <script type="text/javascript">
        function deleteClient(id, name) {
            if (confirm('Delete the ' + name + ' OAuth Client?')) {
                jQuery.ajax({
                    method: "DELETE",
                    url: '/oauthclient/' + id,
                }).done(function (affectedRows) {
                    //if something was deleted, we redirect the user to the users page, and automatically the user that he deleted will disappear
                    if (affectedRows > 0) {
                        window.location = '/oauthclient';
                    }
                });
            }
        }
    </script>
@stop