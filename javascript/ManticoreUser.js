module.exports = function() {
    this.initMemberForm = function () {

        jQuery( '#user #branch' ).change( function () {
            var branch = jQuery( '#branch' ).val();
            jQuery.getJSON( '/api/branch/' + branch + '/grade', function ( result ) {
                jQuery( '#user #display_rank' ).empty();
                jQuery.each( result, function ( key, value ) {
                    jQuery( '#user #display_rank' ).append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                } );
            } );
            jQuery.getJSON( '/api/branch/' + branch + '/rate', function ( result ) {
                jQuery( '#user #rating' ).empty();
                jQuery.each( result, function ( key, value ) {
                    jQuery( '#user #rating' ).append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                } );
            } );

        } );
    };
};