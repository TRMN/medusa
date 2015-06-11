var ManticoreAuth = require( './ManticoreAuth.js' );
var ManticoreUser = require( './ManticoreUser.js' );
var ManticoreChapter = require( './ManticoreChapter.js' );
var ManticoreRegister = require( './ManticoreRegister.js');

jQuery( document ).ready( function ( $ ) {

    var authController = new ManticoreAuth();
    var userController = new ManticoreUser();
    var chapterController = new ManticoreChapter();
	var registerController = new ManticoreRegister();

    if ( $( '.userform' ).length > 0 ) {
        userController.initMemberForm();
    }

	if ($('.registerform').length > 0) {
		registerController.initRegisterForm();
	}

} );
