var ManticoreAuth = require('./ManticoreAuth.js');
var ManticoreUser = require('./ManticoreUser.js');
var ManticoreChapter = require('./ManticoreChapter.js');
var ManticoreRegister = require('./ManticoreRegister.js');
var Dropzone = require('./dropzone.js');

$(document).ready(function ($) {

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
                $('#reload-form').val('yes');
                $('#user').submit();
            });
            this.on('error', function (file, errorMessage) {
                if (errorMessage.indexOf('<html>') >= 0 || errorMessage.indexOf('<HTML>') >= 0) {
                    matches = errorMessage.match(/\<title.*?\>(.*)\<\/title\>/);
                    errorMessage = matches[1].substring(4);
                }
                $('#photoModal p').html(errorMessage);
                $('#photoModal').foundation('reveal', 'open');
            });
        }
    };

    $(document).tooltip({
        items: "[data-src], [title]",
        content: function () {
            var element = $(this);
            if (element.is("[data-src")) {
                var source = element.attr("data-src");
                return "<img src='" + source + "'>";
            }
            if (element.is("[title]")) {
                return element.attr("title");
            }
        }
    });

    $(document).on('opened.fndtn.reveal', '[data-reveal]', function () {
        imageHeight = $('#pm1').height();
        textHeight = $('#pm2 p').height();
        vMargin = ((imageHeight - textHeight) / 2) + 'px';
        $('#pm2').css('margin-top', vMargin);
    });

    $('#chapterList').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            {"orderable": false}
        ]
    });

    $('#reviewApplications').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "language": {
            "emptyTable": "No applications to review"
        },
        "order": [[0, 'asc']],
        "$UI": true
    });

    $('#crewRoster').DataTable({
        "autoWidth": true,
        "pageLength": 25,
        "language": {
            "emptyTable": "No crew members found"
        },
        "$UI": true
    });

    $('#subCrewRoster').DataTable({
        "autoWidth": true,
        "pageLength": 25,
        "columns": [
            {"orderable": false},
            null,
            null,
            null,
            null,
            null
        ],
        "language": {
            "emptyTable": "No crew members found"
        },
        "order": [[0, 'asc']],
        "$UI": true
    });

    $('#changeRequests').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No change requests to review"
        },
        "order": [[0, 'asc']],
        "$UI": true
    });

    $('#billetList').DataTable({
        "autoWidth": true,
        "pageLength": 25,

        "language": {
            "emptyTable": "No billets found"
        },
        "$UI": true
    });

    $('.trmnTable').DataTable({
        "autoWidth": true,
        "pageLength": 25,
        "columnDefs": [{"orderable": false, "targets": -1}],
        "language": {
            "emptyTable": "No records found"
        },
        "$UI": true
    });

    $('.trmnTableWithActions').DataTable({
        "autoWidth": false,
        "pageLength": 25,
        "columnDefs": [{"orderable": false, "targets": -1}],
        "language": {
            "emptyTable": "No records found"
        },
        "$UI": true
    });

    $('#members').tabs();

    $('#DUTY_ROSTER').on('click', function () {
        if ($("#DUTY_ROSTER").is(':checked')) {
            buildDutyRosterSelection();
            $('#chooseShip').foundation('reveal', 'open');
        }
    });

    function buildDutyRosterSelection() {
        var primary = $('#primary_assignment option:selected').val();
        var primary_text = $('#primary_assignment option:selected').text();
        var secondary = $('#secondary_assignment option:selected').val();
        var secondary_text = $('#secondary_assignment option:selected').text();
        var additional = $('#additional_assignment option:selected').val();
        var additional_text = $('#additional_assignment option:selected').text();
        var duty_roster = $('#dutyroster').val();

        $('#selectDR').empty();

        if (primary != 0) {
            var select = '<input class="dr"';
            if (primary == duty_roster) {
                select += ' checked="checked"';
            }
            select += ' name="dr_radio" type="radio" value="' + primary + '">' + primary_text + '</option>';

            $('#selectDR').append(select);
        }

        if (secondary != 0) {
            var select = '<br /><input class="dr"';
            if (secondary == duty_roster) {
                select += ' checked="checked"';
            }
            select += ' name="dr_radio" type="radio" value="' + secondary + '">' + secondary_text + '</option>';
            $('#selectDR').append(select);
        }

        if (additional != 0) {
            var select = '<br /><input class="dr"';
            if (additional == duty_roster) {
                select += ' checked="checked"';
            }
            select += ' name="dr_radio" type="radio" value="' + additional + '">' + additional_text + '</option>';
            $('#selectDR').append(select);
        }
    }

    $('.dr').on('click', function () {
        $('#dutyroster').val($('.dr:checked').val());
    });

    $('#refreshExamList').on('click', function () {
        $.get('/report/getexams/' + $('#chapter_id').val(), function (data) {
            $('#results').html(data);
        });
    });

    $('#copyExams').on('click', function () {
        $('#courses').val($('#courses').val() + $('#results').val());
        $('#examList').foundation('reveal', 'close');
    });

    $('#coPerms').on('click', function () {

        $('#DUTY_ROSTER').prop('checked', true);

        buildDutyRosterSelection();

        $('#EXPORT_ROSTER').prop('checked', true);
        $('#EDIT_WEBSITE').prop('checked', true);
        $('#ASSIGN_NONCOMMAND_BILLET').prop('checked', true);
        $('#PROMOTE_E6O1').prop('checked', true);
        $('#REQUEST_PROMOTION').prop('checked', true);
        $('#CHAPTER_REPORT').prop('checked', true);


        $('#chooseShip').foundation('reveal', 'open');
        return false;
    });

    $('#slPerms').on('click', function () {
        $('#VIEW_CHAPTER_REPORTS').prop('checked', true);
        return false;
    });

    $('#rmaPerms').on('click', function () {
        $('#ADD_UNIT').prop('checked', true);
        $('#EDIT_UNIT').prop('checked', true);
        $('#DELETE_UNIT').prop('checked', true);
        return false;
    });

    $('#rmmcPerms').on('click', function () {
        $('#ADD_MARDET').prop('checked', true);
        $('#EDIT_MARDET').prop('checked', true);
        $('#DELETE_MARDET').prop('checked', true);
        return false;
    });

    $('#defaultPerms').on('click', function () {
        $('.permissions').prop('checked', false);
        $('#LOGOUT').prop('checked', true);
        $('#CHANGE_PWD').prop('checked', true);
        $('#EDIT_SELF').prop('checked', true);
        $('#ROSTER').prop('checked', true);
        $('#TRANSFER').prop('checked', true);
        $('#dutyroster').val('');
        return false;
    });


    $('#duplicates').DataTable({
        "autoWidth": true,
        "pageLength": 50,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            {"orderable": false}
        ],
        "language": {
            "emptyTable": "No members for this branch"
        },
        "order": [[2, 'asc']],
        "$UI": true
    });

    $('#uploadGrades').on('click', function () {
        $('.wait').show();
    });

    $(function () {
        $('.sbAccordian').accordion({
            active: false,
            collapsible: true,
            header: "h5",
            heightStyle: "content",
            icons: {"header": "ui-icon-plus", "activeHeader": "ui-icon-minus"}
        });
    });

    $('#order').hide();
    $('#class').hide();
    $('#generation').hide();
    $('#lands').hide();
    $('#save_peerage').hide();
    $('#arms').hide();
    $('#arms-label').hide();
    $('#cancel').hide();

    $('#ptitle').on('change', function () {
        if ($('#ptitle').val() == "Knight" || $('#ptitle').val() == "Dame") {
            $('#order').show();
            $('#generation').hide();
            $('#lands').hide();
            $('#arms').hide();
            $('#arms-label').hide();
            $('#save_peerage').hide();
            $('#cancel').hide();
        } else {
            $('#order').hide();
            $('#class').hide();
            $('#generation').show();
            if ($("#lands").val().length == 0) {
                $('#save_peerage').hide();
                $('#cancel').hide();
            }

        }

    });

    $('#cancel').on('click', function () {
        $('#order').hide();
        $('#class').hide();
        $('#generation').hide();
        $('#lands').hide();
        $('#arms').hide();
        $('#arms-label').hide();
        $('#save_peerage').hide();
        $('#cancel').hide();
        $('#peerage-container').trigger('click');
        return false;
    });

    $('#generation').on('change', function () {
        $('#lands').show();
        $('#arms').show();
        $('#arms-label').show();
        $('#save_peerage').show();
        $('#cancel').show();
    });

    $('#order').on('change', function () {
        $.getJSON('/api/korder/' + $('#order').val(), function (result) {
            $('#class').empty();
            $('#class').append(
                '<option value="">Select Class</option>'
            );
            $.each(result, function (key, value) {
                $('#class').append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            });
        });
        $('#class').show();
        $('#save_peerage').show();
        $('#cancel').show();
    });

    $('#peerage_form').on('submit', function () {
        var error_msg = [];
        // Check that a peerage was selected
        if ($('#ptitle').val() == '') {
            error_msg.push('You must select a Peerage title');
        }
        // Contional error checking based on peerate title

        if ($("#ptitle").val() == "Knight" || $("#ptitle").val() == "Dame") {
            if ($("#order").val() == '') {
                error_msg.push('You must select an Order');
            }

            if ($("#class").val() == '') {
                error_msg.push('You must select a class of Knighthood');
            }
        } else {
            if ($("#generation").val() == '') {
                error_msg.push('You must select a generation');
            }

            if ($('#lands').val().length == 0) {
                error_msg.push('You must provide the name of the Peerage lands');
            }

            if ($('#arms').val().length > 0) {
                // Check the file extension, we only accept .svg files
                // get the file name, possibly with path (depends on browser)
                var filename = $("#arms").val();

                // Use a regular expression to trim everything before final dot
                var extension = filename.replace(/^.*\./, '');

                // Iff there is no dot anywhere in filename, we would have extension == filename,
                // so we account for this possibility now
                if (extension == filename) {
                    extension = '';
                } else {
                    // if there is an extension, we convert to lower case
                    // (N.B. this conversion will not effect the value of the extension
                    // on the file upload.)
                    extension = extension.toLowerCase();
                }

                if (extension != 'svg') {
                    error_msg.push('Only .svg files may be used for Peerage arms');
                }
            }
        }

        if (error_msg.length > 0) {
            var text = '';

            for (var i in error_msg) {
                text += error_msg[i];
                text += "\n";
            }

            alert(text);
            return false;
        }

        return true;
    });

    $('.delete_peerage').on('click', function () {
        var element = $(this);

        if (confirm('Delete ' + element.attr('data-peerage-text') + '?')) {
            location.href = "/user/" + element.attr('data-user-id') + "/peerage/" + element.attr('data-peerage-id');
        }
    });

    $('.edit_peerage').on('click', function () {
        var element = $(this);

        $('<input>').attr({
            type: 'hidden',
            name: 'peerage_id',
            value: element.attr('data-peerage-id')
        }).appendTo('#peerage_form');

        if (element.attr('data-peerage-filename').length > 0) {
            $('<input>').attr({
                type: 'hidden',
                name: 'filename',
                value: element.attr('data-peerage-filename')
            }).appendTo('#peerage_form');
        }

        var title = element.attr('data-peerage-title');

        $("#ptitle option[value='" + title + "']").prop('selected', true);

        if (title == "Knight" || title == "Dame") {
            $("#order option[value='" + element.attr('data-peerage-order') + "']").prop('selected', true);
            $("#order").trigger('change');

            // Make sure that we populate the class drop down
            $.getJSON('/api/korder/' + $('#order').val(), function (result) {
                var pclass = element.attr('data-peerage-class');

                $('#class').empty();
                $('#class').append(
                    '<option value="">Select Class</option>'
                );
                $.each(result, function (key, value) {
                    var extra = '';
                    if (key == pclass) {
                        extra = ' selected';
                    }
                    $('#class').append(
                        '<option value="' + key + '"' + extra + '>' + value + '</option>'
                    );
                });
            });
        } else {
            $("#generation option[value='" + element.attr('data-peerage-generation') + "']").prop('selected', true);
            $("#lands").val(element.attr('data-peerage-lands'));

            $('#generation').trigger('change');
        }

        if (element.attr('data-peerage-courtesy') == 1) {
            $('#courtesy').prop('checked', true);
        } else {
            $('#courtesy').prop('checked', false);
        }

        $('#ptitle').trigger('change');
        $('#save_peerage').show();
        $('#cancel').show();
        $('#peerage-container').trigger('click');
    });

    $('#note_delete').on('click', function() {
        $('#note_text').val('');
        $('#note_form').submit();
    });
    
    $('#note_cancel').on('click', function () {
        $('#note_container').trigger('click');
        return false;
    });
    
});
