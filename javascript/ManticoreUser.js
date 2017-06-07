module.exports = function () {
    this.initMemberForm = function () {

        jQuery('#user #branch').change(function () {
            var branch = jQuery('#branch').val();
            jQuery.getJSON('/api/branch/' + branch + '/grade', function (result) {
                var grade = jQuery('#user #display_rank').val();
                var options = '';

                jQuery('#user #display_rank').empty();
                jQuery.each(result, function (key, value) {

                    var option = '';
                    option = '<option value="' + key + '"';
                    if (grade == key) {
                        option += ' selected';
                    }
                    options += option + '>' + value + '</option>';

                });
                jQuery('#user #display_rank').append(options);
            });
            jQuery.getJSON('/api/branch/' + branch + '/rate', function (result) {
                jQuery('#user #rating').empty();
                jQuery.each(result, function (key, value) {
                    jQuery('#user #rating').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            });

        });

        jQuery('#plocation').change({assignment: 'primary'}, getChapterList);
        jQuery('#slocation').change({assignment: 'secondary'}, getChapterList);
        jQuery('#alocation').change({assignment: 'additional'}, getChapterList);
        jQuery('#elocation').change({assignment: 'extra'}, getChapterList);

        buildChapterList('primary');
        buildChapterList('secondary');
        buildChapterList('additional');
        buildChapterList('extra');

        function getChapterList(event) {
            var assignemnt = event.data.assignment;
            buildChapterList(assignemnt);
        }

        function buildChapterList(assignment) {
            jQuery.ajax({
                url: '/api/chapterselection',
                dataType: 'json',
                success: function (result) {
                    jQuery('#' + assignment + '_assignment').empty();
                    jQuery('#' + assignment + '_assignment').append('<option value="0">Select a Chapter');
                    jQuery.each(result, function(key, chapterType) {
                        if ((jQuery('#showUnjoinable').val() === "true" && chapterType.unjoinable === true) || chapterType.unjoinable === false) {
                            jQuery('#' + assignment + '_assignment').append('<optgroup label="' + chapterType.label + '">' + getURI(chapterType.url, assignment.charAt(0) + 'assignment') + '</optgroup>');
                        }
                    })

                    jQuery('#' + assignment + '_assignment').selectize({
                        sortField: 'text'
                    });
                }
            })
        }

        function getURI(url, sel) {
            var options = '';
            jQuery.ajax({
                url: url,
                dataType: 'json',
                async: false,
                success: function (result) {
                    jQuery.each(result, function (key, value) {
                        var option = '';
                        option = '<option value="' + key + '"';
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