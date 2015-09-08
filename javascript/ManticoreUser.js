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

        jQuery('#plocation').change({assignment: 'primary'}, getChapterList);
        jQuery('#slocation').change({assignment: 'secondary'}, getChapterList);

        buildChapterList('primary');
        buildChapterList('secondary');

        function getChapterList(event) {
            var assignemnt = event.data.assignment;
            buildChapterList(assignemnt);
        }

        function buildChapterList(assignment) {
            jQuery('#' + assignment + '_assignment').empty();
            jQuery('#' + assignment + '_assignment').append('<option value="0">Select a Chapter');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="Holding Chapters">' + getURI('holding', assignment.charAt(0) + 'assignment') + '</optgroup>');
            if (jQuery('#showUnjoinable').val() == 'true') {
                jQuery('#' + assignment + '_assignment').append('<optgroup label="Headquarters">' + getURI('hq', assignment.charAt(0) + 'assignment') + '</optgroup>');
                jQuery('#' + assignment + '_assignment').append('<optgroup label="Bureaus">' + getURI('bureau', assignment.charAt(0) + 'assignment') + '</optgroup>');
                jQuery('#' + assignment + '_assignment').append('<optgroup label="Fleets">' + getURI('fleet', assignment.charAt(0) + 'assignment') + '</optgroup>');
                jQuery('#' + assignment + '_assignment').append('<optgroup label="Separation Units">' + getURI('su', assignment.charAt(0) + 'assignment') + '</optgroup>');
            }
            jQuery('#' + assignment + '_assignment').append('<optgroup label="RMN">' + getURI('chapter/RMN/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="RMMC">' + getURI('chapter/RMMC/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="RMA">' + getURI('chapter/RMA/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="GSN">' + getURI('chapter/GSN/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="IAN">' + getURI('chapter/IAN/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="RHN">' + getURI('chapter/RHN/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="SFS">' + getURI('chapter/SFS/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="CIVIL">' + getURI('chapter/CIVIL/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
            jQuery('#' + assignment + '_assignment').append('<optgroup label="INTEL">' + getURI('chapter/INTEL/' + jQuery('#' + assignment.charAt(0) + 'location').val(), assignment.charAt(0) + 'assignment') + '</optgroup>');
        }

        function getURI(url, sel) {
            var options = '';
            jQuery.ajax({
                url: '/api/' + url,
                dataType: 'json',
                async: false,
                success: function (result) {
                    jQuery.each(result, function (key, value) {
                        var option = '';
                        option = '<option value="' + key +'"';
                        if (jQuery('#' + sel).val() == key) {
                            option += ' selected';
                        }
                        options += option + '>' + value + '</option>';

                    });
                }
            });

            if (options == '') {
                options = '<option disabled>No Chapters Found</option>';
            }
            return options;
        }

    };
};