module.exports = function() {
    this.initMemberForm = function () {

        jQuery.getJSON( '/api/chapter', function ( result ) {
            jQuery( '#newuser #primary_assignment' ).empty();
            jQuery.each( result, function ( key, value ) {
                jQuery( '#newuser #primary_assignment' ).append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            } );
        } );

        jQuery( '#user #branch' ).change( function () {
			alert('New User');
            var branch = jQuery( '#branch' ).val();
            jQuery.getJSON( '/api/branch/' + branch + '/grade', function ( result ) {
                jQuery( '#user #permanent_rank' ).empty();
                jQuery( '#user #brevet_rank' ).empty();
                jQuery.each( result, function ( key, value ) {
                    jQuery( '#user #permanent_rank' ).append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                    jQuery( '#user #brevet_rank' ).append(
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