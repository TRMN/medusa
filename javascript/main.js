var ManticoreAuth = require( './ManticoreAuth.js' );
var ManticoreUser = require( './ManticoreUser.js' );
var ManticoreChapter = require( './ManticoreChapter.js' );

jQuery( document ).ready( function ( $ ) {

    var authController = new ManticoreAuth();
    var userController = new ManticoreUser();
    var chapterController = new ManticoreChapter();

    if ( $( '.userform' ).length > 0 ) {
        userController.initMemberForm();
    }

} );
