module.exports = function () {

    this.doLogin = function ( email, password ) {

        var data = { email: '', password: '' };
        data.email = email;
        data.password = password;

        jQuery( '.error-message' ).html( '' );

        jQuery.post( '/signin', data, function ( result ) {

            if ( result.status == 'success' ) {
                window.location = '/dashboard';
            } else {
                jQuery( '.error-message' ).html( 'There was a problem logging you in. Please check your email and password and try again.' );
                jQuery( '#signin-btn' ).prop( 'disabled', false );
            }

        }, 'json' );

    };

};

