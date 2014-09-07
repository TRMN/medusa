jQuery( document ).ready( function( $ ) {
    $( 'signin-btn' ).click( function() {
        var data = { email: '', password: '' };
        data.email = $( '#email' ).val();
        data.password = $( '#password' ).val();
        $( 'signin-btn' ).prop( 'disabled', true );
        $.post( '/signin', data, function( response ) {
            if ( response.result == 'success' ) {
                $( '#username' ).html( response.username );
                $( '#signin-form' ).hide();
                $( '#user-info' ).show();
            } else {
                if ( response.error ) {
                    $( '#error' ).html( response.error );
                } else {
                    $( '#error' ).html( 'Sorry, there was a problem logging you in. Please try again.' );
                }
            }
            $( 'signin-btn' ).prop( 'disabled', false );
        });
    });
});