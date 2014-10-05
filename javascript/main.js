jQuery( document ).ready( function ( $ ) {
    $( '#signin-btn' ).click( function () {
        var data = { email: '', password: '' };
        data.email = $( '#email' ).val();
        data.password = $( '#password' ).val();
        $( '#signin-btn' ).prop( 'disabled', true );
        $.post( '/signin', data, function ( result ) {
            $( '#signin-btn' ).prop( 'disabled', false );
            if ( result.status == 'success' ) {
                window.location = '/dashboard';
            } else {
                console.log( result );
            }
        }, 'json' );
        return false;
    } );

    $( '.delete-chapter' ).click( function () {
        var chapterId = $( this ).attr( 'data-mongoid' );
        var containingRow = $( this ).parent().parent();
        if ( typeof chapterId !== 'undefined' && chapterId !== '' ) {
            $.ajax( {
                'url': '/chapter/' + chapterId,
                'type': 'DELETE',
                'success': function () {
                    containingRow.remove();
                    alert( 'Deleted successfully.' );
                }
            } );
        }
    } );
} );