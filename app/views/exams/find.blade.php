@extends('layout')

@section('pageTitle')
    Manage / Enter Grades
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Manage / Enter Grades</h1>

    <div class="row">
        <div class="columns small-6 ninety Incised901Light end">
            <input type="text" name="query" id="query" placeholder="Start typing RMN number or name"/>
        </div>
    </div>
@stop
@section('scriptFooter')
<script type="text/javascript">
$('#query').devbridgeAutocomplete({
    serviceUrl: '/api/find',
    onSelect: function (suggestion) {
        alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    }
});
</script>
@stop