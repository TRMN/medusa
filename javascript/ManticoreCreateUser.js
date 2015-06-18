module.exports = function () {
    this.initCreateMemberForm = function () {

        jQuery('#newuser #branch').change(function () {
            var branch = jQuery('#branch').val();
            jQuery.getJSON('/api/branch/' + branch + '/grade', function (result) {
                jQuery('#newuser #display_rank').empty();
                jQuery.each(result, function (key, value) {
                    jQuery('#newuser #display_rank').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            });
            jQuery.getJSON('/api/branch/' + branch + '/rate', function (result) {
                jQuery('#newuser #rating').empty();
                jQuery.each(result, function (key, value) {
                    jQuery('#newuser #rating').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
            });
        });
    };
};