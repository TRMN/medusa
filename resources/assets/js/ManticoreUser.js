module.exports = function () {
    this.initMemberForm = function () {

        jQuery('#user #branch').on('change', function () {
            var branch = jQuery('#branch').val();
            jQuery.getJSON('/api/branch/' + branch + '/grade', function (result) {
                var grade = jQuery('#user #rank').val();
                var options = '';

                jQuery('#user #rank').empty();
                options = '<option value="">Select a Rank</option>';
                jQuery.each(result, function (key, value) {
                    options  += '<optgroup label="' + key + '">';

                    jQuery.each(value, function (key, value) {
                        var option = '';
                        option = '<option value="' + key + '"';
                        if (grade == key) {
                            option += ' selected';
                        }
                        options += option + '>' + value + '</option>';
                    });

                    options += '</optgroup>';
                });
                jQuery('#user #rank').append(options);
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

        // jQuery.each(['primary', 'secondary', 'additional', 'extra'], function (key, assignment) {
        //     jQuery('#' + assignment + '_assignment').selectize({
        //         sortField: 'text',
        //         lockOptgroupOrder: true
        //     });
        // });

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