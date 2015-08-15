module.exports = function() {
    this.initRegisterForm = function () {

        jQuery('#register #location').change(buildChapterList);

        buildChapterList();

        function buildChapterList() {
            jQuery('#register #primary_assignment').empty();
            jQuery('#register #primary_assignment').append('<option value="0">Select a Chapter');
            jQuery('#register #primary_assignment').append('<optgroup label="Holding Chapters">' + getURI('holding') + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="RMN">' + getURI('chapter/RMN/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="RMMC">' + getURI('chapter/RMMC/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="RMA">' + getURI('chapter/RMA/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="GSN">' + getURI('chapter/GSN/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="IAN">' + getURI('chapter/IAN/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="RHN">' + getURI('chapter/RHN/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="SFS">' + getURI('chapter/SFS/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="CIVIL">' + getURI('chapter/CIVIL/' + jQuery('#register #location').val()) + '</optgroup>');
            jQuery('#register #primary_assignment').append('<optgroup label="INTEL">' + getURI('chapter/INTEL/' + jQuery('#register #location').val()) + '</optgroup>');
        }

        function getURI(url) {
            var options = '';
            jQuery.ajax({
                url: '/api/' + url,
                dataType: 'json',
                async: false,
                success: function (result) {
                    jQuery.each(result, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';

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