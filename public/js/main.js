jQuery( document ).ready( function( $ ) {
    $( 'signin-btn' ).click( function() {
        var data = { email: '', password: '' };
        data.email = $( '#email' ).val();
        data.password = $( '#password' ).val();
        $( 'signin-btn' ).prop( 'disabled', true );
        $.post( '/signin', data, function( response ) {
            $( 'signin-btn' ).prop( 'disabled', false );
        });
        console.log( 'Signed in' );
    });
});