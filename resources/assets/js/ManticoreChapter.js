module.exports = function() {
    this.initList = function () {
        jQuery( '.delete-chapter' ).click( function () {
            var chapterId = $( this ).attr( 'data-mongoid' );
            var containingRow = $( this ).parent().parent();
            if ( typeof chapterId !== 'undefined' && chapterId !== '' ) {
                jQuery.ajax( {
                    'url': '/chapter/' + chapterId,
                    'type': 'DELETE',
                    'success': function () {
                        containingRow.remove();
                        alert( 'Deleted successfully.' );
                    }
                } );
            }
        } );
    };
};
