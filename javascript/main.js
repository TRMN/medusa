var ManticoreAuth = require('./ManticoreAuth.js');
var ManticoreUser = require('./ManticoreUser.js');
var ManticoreChapter = require('./ManticoreChapter.js');
var ManticoreRegister = require('./ManticoreRegister.js');
var Dropzone = require('./dropzone.js');

jQuery(document).ready(function ($) {

    var authController = new ManticoreAuth();
    var userController = new ManticoreUser();
    var chapterController = new ManticoreChapter();
    var registerController = new ManticoreRegister();

    if ($('.userform').length > 0) {
        userController.initMemberForm();
    }

    if ($('.registerform').length > 0) {
        registerController.initRegisterForm();
    }

    var MTIProjectId = '5c059f73-3466-4691-8b9a-27e7d9c1a9c7';
    (function () {
        var mtiTracking = document.createElement('script');
        mtiTracking.type = 'text/javascript';
        mtiTracking.async = 'true';
        mtiTracking.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//fast.fonts.net/t/trackingCode.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(mtiTracking);
    })();


    Dropzone.options.trmnDropzone = {
        url: "/api/photo",
        acceptedFiles: ".png,.gif,.jpg",
        uploadMultiple: false,
        clickable: true,
        previewTemplate: '<div style="display:none"></div>',
        createImageThumbnails: false,
        dictDefaultMessage: 'Click or Drop<br />File Here<br />&nbsp;<br />150 px X 200 px',
        dictInvalidFileType: 'Only .png, .gif and .jpg images will be accepted',
        init: function () {
            this.on("success", function (file) {
                jQuery('#reload-form').val('yes');
                jQuery('#user').submit();
            });
            this.on('error', function (file, errorMessage) {
                if (errorMessage.indexOf('<html>') >= 0 || errorMessage.indexOf('<HTML>') >= 0) {
                    matches = errorMessage.match(/\<title.*?\>(.*)\<\/title\>/);
                    errorMessage = matches[1].substring(4);
                }
                jQuery('#photoModal p').html(errorMessage);
                jQuery('#photoModal').foundation('reveal', 'open');
            });
        }
    };

    jQuery(document).tooltip({
        tooltipClass: "Incised901Light"
    });

    jQuery(document).on('opened.fndtn.reveal', '[data-reveal]', function () {
        imageHeight = jQuery('#pm1').height();
        console.log('Image Height ' + imageHeight);
        textHeight = jQuery('#pm2 p').height();
        console.log('Text Height ' + textHeight);
        vMargin = ((imageHeight - textHeight) / 2) + 'px';
        console.log('Top Margin ' + vMargin);
        jQuery('#pm2').css('margin-top', vMargin);
    });
});
