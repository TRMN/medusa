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
        textHeight = jQuery('#pm2 p').height();
        vMargin = ((imageHeight - textHeight) / 2) + 'px';
        jQuery('#pm2').css('margin-top', vMargin);
    });

    jQuery('#chapterList').DataTable( {
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            {"orderable": false}
        ]
    });

    jQuery('#memberList-1').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order" : [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-2').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-3').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-4').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-5').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-6').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-7').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-8').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#memberList-9').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#reviewApplications').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[0, 'asc']],
        "jQueryUI": true
    });

    jQuery('#members').tabs();
});
