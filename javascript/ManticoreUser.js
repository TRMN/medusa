module.exports = function() {
    this.initMemberForm = function () {

        jQuery.getJSON( '/api/country', function ( result ) {
            jQuery( '#country' ).empty();
            jQuery.each( result, function ( key, value ) {
                jQuery( '#country' ).append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            } );
        } );

        jQuery.getJSON( '/api/branch', function ( result ) {
            jQuery( '#branch' ).empty();
            jQuery.each( result, function ( key, value ) {
                jQuery( '#branch' ).append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            } );
        } );

        jQuery.getJSON( '/api/chapter', function ( result ) {
            jQuery( '#newuser #primary_assignment' ).empty();
            jQuery.each( result, function ( key, value ) {
                jQuery( '#newuser #primary_assignment' ).append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            } );
        } );

        jQuery( '#perm_dor' ).datepicker( { dateFormat: "yy-mm-dd" } );
        jQuery( '#brevet_dor' ).datepicker( { dateFormat: "yy-mm-dd" } );
        jQuery( '#primary_date_assigned' ).datepicker( { dateFormat: "yy-mm-dd" } );
        jQuery( '#secondary_date_assigned' ).datepicker( { dateFormat: "yy-mm-dd" } );

        jQuery( '#newuser #branch' ).change( function () {
			alert('New User');
            var branch = jQuery( '#branch' ).val();
            jQuery.getJSON( '/api/branch/' + branch + '/grade', function ( result ) {
                jQuery( '#newuser #permanent_rank' ).empty();
                jQuery( '#newuser #brevet_rank' ).empty();
                jQuery.each( result, function ( key, value ) {
                    jQuery( '#newuser #permanent_rank' ).append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                    jQuery( '#newuser #brevet_rank' ).append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                } );
            } );
            jQuery.getJSON( '/api/branch/' + branch + '/rate', function ( result ) {
                jQuery( '#newuser #rating' ).empty();
                jQuery.each( result, function ( key, value ) {
                    jQuery( '#newuser #rating' ).append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                } );
            } );
        } );
    };
};