// var ManticoreAuth = require('./ManticoreAuth.js');
var ManticoreUser = require('./ManticoreUser.js');
var ManticoreChapter = require('./ManticoreChapter.js');
var ManticoreRegister = require('./ManticoreRegister.js');
var Dropzone = require('./dropzone.js');

$(document).ready(function ($) {

    // var authController = new ManticoreAuth();
    var userController = new ManticoreUser();
    var chapterController = new ManticoreChapter();
    // var registerController = new ManticoreRegister();

    if ($('.userform').length > 0) {
        userController.initMemberForm();
    }

    // if ($('.registerform').length > 0) {
    //     registerController.initRegisterForm();
    // }

    var MTIProjectId = '5c059f73-3466-4691-8b9a-27e7d9c1a9c7';
    (function () {
        var mtiTracking = document.createElement('script');
        mtiTracking.type = 'text/js';
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

    $('[data-toggle="tooltip"]').tooltip();

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
        "columnDefs": [{type: 'natural-nohtml', targets: '_all'}],
        "language": {
            "emptyTable": "No records found"
        },
        "$UI": true
    });

    $('.crewlist').DataTable({
        "autoWidth": true,
        "pageLength": 10,
        "columnDefs": [
            {"orderable": false, "targets": 0},
            {"orderable": true, "targets": -1}
        ],
        "language": {
            "emptyTable": "None"
        },
        "order": [[3, 'desc']],
        "$UI": true,
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]

    });

    $('.trmnTableWithActions').DataTable({
        "autoWidth": false,
        "pageLength": 25,
        "columnDefs": [
            {"orderable": false, "targets": -1},
            {type: 'natural-nohtml', targets: '_all'}
        ],
        "language": {
            "emptyTable": "No records found"
        },
        "$UI": true
    });

    $('#members').tabs();

    $('#DUTY_ROSTER').on('click', function () {
        if ($("#DUTY_ROSTER").is(':checked')) {
            buildDutyRosterSelection();
            $('#chooseShip').modal('show');
        }
    });

    function buildDutyRosterSelection() {
        var primary = $('#primary_assignment option:selected').val();
        var primary_text = $('#primary_assignment option:selected').text();
        var secondary = $('#secondary_assignment option:selected').val();
        var secondary_text = $('#secondary_assignment option:selected').text();
        var additional = $('#additional_assignment option:selected').val();
        var additional_text = $('#additional_assignment option:selected').text();
        var suplemental = $('#extra_assignment option:selected').val();
        var suplemental_text = $('#extra_assignment option:selected').text();
        var duty_roster = $('#dutyroster').val();

        $('#selectDR').empty();

        if (primary != 0) {
            var select = '<input class="dr"';
            if (duty_roster.indexOf(primary) != -1) {
                select += ' checked="checked"';
            }
            select += ' name="dr_check[]" type="checkbox" value="' + primary + '">' + primary_text + '</option>';

            $('#selectDR').append(select);
        }

        if (secondary != 0) {
            var select = '<br /><input class="dr"';
            if (duty_roster.indexOf(secondary) != -1) {
                select += ' checked="checked"';
            }
            select += ' name="dr_check[]" type="checkbox" value="' + secondary + '">' + secondary_text + '</option>';
            $('#selectDR').append(select);
        }

        if (additional != 0) {
            var select = '<br /><input class="dr"';
            if (duty_roster.indexOf(additional) != -1) {
                select += ' checked="checked"';
            }
            select += ' name="dr_check[]" type="checkbox" value="' + additional + '">' + additional_text + '</option>';
            $('#selectDR').append(select);
        }

        if (suplemental != 0) {
            var select = '<br /><input class="dr"';
            if (duty_roster.indexOf(suplemental) != -1) {
                select += ' checked="checked"';
            }
            select += ' name="dr_check[]" type="checkbox" value="' + suplemental + '">' + suplemental_text + '</option>';
            $('#selectDR').append(select);
        }
    }

    $('.dr').on('click', function () {
        if ($('#dutyroster').val().length == 0) {
            $('#dutyroster').val($(this).val());
        } else {
            $('#dutyroster').val($('#dutyroster').val() + ',' + $(this).val());
        }
    });

    $('#refreshExamList').on('click', function () {
        $.get('/report/getexams/' + $('#chapter_id').val(), function (data) {
            $('#results').val(data);
        });
        $('#examList').modal('show');
    });

    $('#copyExams').on('click', function () {
        $('#courses').val($('#courses').val() + $('#results').val());
        $('#examList').modal('hide');
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
            $('#courtesy').hide();
            $('#courtesy_label').hide();
            if ($('#order').val() != 'Select Order') {
                $('#class').show();
                $('#save_peerage').show();
                $('#cancel').show();
            }
        } else {
            $('#order').hide();
            $('#class').hide();
            $('#generation').show();
            $('#courtesy').show();
            $('#courtesy_label').show();
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

    $('#note_clear').on('click', function () {
        $('#note_text').val('');
        $('#note_form').submit();
    });

    $('#note_cancel').on('click', function () {
        $('#note_container').trigger('click');
        location.reload();
        return false;

    });

    $('.delete-exam').on('click', function () {
        var item = $(this);
        var examID = item.attr('data-examID');
        var memberNumber = item.attr('data-memberNumber');
        var fullName = item.attr('data-fullName');

        $('#confirmMessage').html('Delete exam ' + examID + " from " + fullName + "'s record?");
        $('#delete-exam-form').html('<input type="hidden" name="examID" value="' + examID + '">' +
            '<input type="hidden" name="memberNumber" value="' + memberNumber + '">');
        $('#confirmExamDelete').modal('show');
    });

    $('#examDeleteYes').on('click', function() {
        $('#confirmExamDelete').modal('hide');
        $('#examDeleteForm').submit();
    });

    $('.selectize').selectize({
        sortField: 'text',
        lockOptgroupOrder: true
    });

    $('.sbAccordian').accordion({
        active: false,
        collapsible: true,
        header: "h5",
        heightStyle: "content",
        icons: {"header": "ui-icon-plusthick", "activeHeader": "ui-icon-minusthick"}
    });

    $('#left-nav').accordion({
        active: Cookies.get('saved_index') == undefined ? 0 : parseInt(Cookies.get('saved_index')),
        collapsible: true,
        header: "h3",
        heightStyle: "content",
        icons: {"header": "ui-icon-plusthick", "activeHeader": "ui-icon-minusthick"},
        activate: function (event, ui) {
            Cookies.set('saved_index', $("#left-nav")
                .accordion("option", "active"));
        }
    });

    $('[data-toggle="popover"]').popover();

    $('#path').on('change', function() {
        var path = $('#path :selected').val();
        var user_id = $('#path').data('id');

        $.post( "/api/path", { user_id: user_id, path:  path} );
    });

    $('.toggle-nav').on('click', function () {
        $('#left').toggle();

        var toggleState = $('#toggle-btn').hasClass('fa-angle-double-left');

        if (toggleState === true) {
            // Change to a right arrow
            $('#toggle-btn').removeClass('fa-angle-double-left');
            $('#toggle-btn').addClass('fa-angle-double-right');
            $('#right-wrapper').removeClass('col-sm-10');
            $('#right-wrapper').addClass('col-sm-12');
        } else {
            // Change to a left arrow
            $('#toggle-btn').removeClass('fa-angle-double-right');
            $('#toggle-btn').addClass('fa-angle-double-left');
            $('#right-wrapper').removeClass('col-sm-12');
            $('#right-wrapper').addClass('col-sm-10');
        }

    });

    $('.pp-calc').on('keyup change', function () {
        calcPoints($(this), false);
    });

    $('.pp-calc-3').on('keyup change', function () {
        calcPoints($(this), true);
    });

    $('.pp-calc-select').on('change', function () {
        calcPointsSelect($(this));
    });

    function calcPoints(el, monthCalc = false) {
        var target = '#' + el.data('target');
        var points = el.data('points');

        if (monthCalc === true) {
            var quantity = parseInt(el.val() / 3);
        } else {
            var quantity = el.val();
        }

        $(target).text(quantity * points);
        $('#total-pp').text(calcTotalPromotionPoints());
    }

    function calcPointsSelect(el) {
        var target = '#' + el.data('target');
        var points = 0;
        var select = el.find(':selected').val();

        switch (select) {
            case 'B':
                points = 1;
                break;
            case 'E':
                points = 2;
                break;
            case 'S':
                points = 4;
                break;
            case 'D':
                points = 4;
                break;
            case 'G':
                points = 7;
                break;
            default:
                points = 0;
                break;
        }

        $(target).text(points);
        $('#total-pp').text(calcTotalPromotionPoints());
    }

    $('#total-pp').text(calcTotalPromotionPoints());

    $('.pp-calc').each(function() {
        calcPoints($(this), false);
    })

    $('.pp-calc-3').each(function() {
        calcPoints($(this), true);
    })

    $('.pp-calc-select').each(function() {
        calcPointsSelect($(this));
    })

    function calcTotalPromotionPoints() {
        var sum = 0;

        $.each([ 'service', 'events', 'parliament', 'peerages', 'awards', 'early' ], function( index, value ) {
            sum += calcSectionPromotionPoints(value);
        });

        return sum;
    }

    function calcSectionPromotionPoints(target) {
        var sum = 0;
        $('#' + target +' .pp').each(function () {
            sum += parseInt($(this).text());
        });

        $('#' + target + '-pp').text(sum);
        return sum;
    }

    (function () {

        /*
         * Natural Sort algorithm for Javascript - Version 0.7 - Released under MIT license
         * Author: Jim Palmer (based on chunking idea from Dave Koelle)
         * Contributors: Mike Grier (mgrier.com), Clint Priest, Kyle Adams, guillermo
         * See: http://js-naturalsort.googlecode.com/svn/trunk/naturalSort.js
         */
        function naturalSort(a, b, html) {
            var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?$|^0x[0-9a-f]+$|[0-9]+)/gi,
                sre = /(^[ ]*|[ ]*$)/g,
                dre = /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/,
                hre = /^0x[0-9a-f]+$/i,
                ore = /^0/,
                htmre = /(<([^>]+)>)/ig,
                // convert all to strings and trim()
                x = a.toString().replace(sre, '') || '',
                y = b.toString().replace(sre, '') || '';
            // remove html from strings if desired
            if (!html) {
                x = x.replace(htmre, '');
                y = y.replace(htmre, '');
            }
            // chunk/tokenize
            var xN = x.replace(re, '\0$1\0').replace(/\0$/, '').replace(/^\0/, '').split('\0'),
                yN = y.replace(re, '\0$1\0').replace(/\0$/, '').replace(/^\0/, '').split('\0'),
                // numeric, hex or date detection
                xD = parseInt(x.match(hre), 10) || (xN.length !== 1 && x.match(dre) && Date.parse(x)),
                yD = parseInt(y.match(hre), 10) || xD && y.match(dre) && Date.parse(y) || null;

            // first try and sort Hex codes or Dates
            if (yD) {
                if (xD < yD) {
                    return -1;
                }
                else if (xD > yD) {
                    return 1;
                }
            }

            // natural sorting through split numeric strings and default strings
            for (var cLoc = 0, numS = Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
                // find floats not starting with '0', string or 0 if not defined (Clint Priest)
                var oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc], 10) || xN[cLoc] || 0;
                var oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc], 10) || yN[cLoc] || 0;
                // handle numeric vs string comparison - number < string - (Kyle Adams)
                if (isNaN(oFxNcL) !== isNaN(oFyNcL)) {
                    return (isNaN(oFxNcL)) ? 1 : -1;
                }
                // rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
                else if (typeof oFxNcL !== typeof oFyNcL) {
                    oFxNcL += '';
                    oFyNcL += '';
                }
                if (oFxNcL < oFyNcL) {
                    return -1;
                }
                if (oFxNcL > oFyNcL) {
                    return 1;
                }
            }
            return 0;
        }

        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "natural-asc": function (a, b) {
                return naturalSort(a, b, true);
            },

            "natural-desc": function (a, b) {
                return naturalSort(a, b, true) * -1;
            },

            "natural-nohtml-asc": function (a, b) {
                return naturalSort(a, b, false);
            },

            "natural-nohtml-desc": function (a, b) {
                return naturalSort(a, b, false) * -1;
            }
        });

    }());

    if ($('#right').height() < $('#left').height()) {
        $('#right').height($('#left').height())
    }
});
