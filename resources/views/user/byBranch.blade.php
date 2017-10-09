@extends('layout')

@section('pageTitle')
    {!! $title !!}
@stop

@section('content')
    <div><h3 class="trmn">{!! $title !!}</h3></div>
    <div>
        @include('user.partials.byBranch', ['branch' => $branch])
    </div>
@stop

@section('scriptFooter')
    <script type="text/javascript">
        $('.trmnUserTable-{{$branch}}').DataTable({
            "autoWidth": false,
            "pageLength": 25,
            "serverSide": true,
            "ajax": {
                url: '/users/list/{{$branch}}',
                type: 'post'
            },
            "columnDefs": [{
                "targets": [0, 2, 6, 8],
                "orderable": false,
                "searchable": false
            }],
            "order": [[3, 'asc']],
            "$UI": true
        });
    </script>
@stop