jQuery( document ).ready( function( $ ) {
    $( '#signin-btn' ).click( function() {
        var data = { email: '', password: '' };
        data.email = $( '#email' ).val();
        data.password = $( '#password' ).val();
        $( '#signin-btn' ).prop( 'disabled', true );
        $.post( '/signin', data, function( result ) {
            $( '#signin-btn' ).prop( 'disabled', false );
            if ( result.status == 'success' ) {
                window.location = '/dashboard';
            } else {
                console.log( result.status );
            }
        }, 'json' );
    });
});