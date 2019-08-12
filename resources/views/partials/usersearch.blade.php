<script type="text/javascript">
    $('#query').devbridgeAutocomplete({
        serviceUrl: '/api/find',
        onSelect: function (suggestion) {
            @if($permsObj->hasPermissions(['EDIT_GRADE'], true))
                window.location = '/user/find/' + suggestion.data;
            @else
                window.location = '/user/' + suggestion.data;
            @endif
        },
        width: 600
    });
</script>