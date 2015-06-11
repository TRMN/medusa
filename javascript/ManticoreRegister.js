module.exports = function() {
    this.initRegisterForm = function () {

		jQuery.getJSON('/api/chapter/RMN', function(result) {
			jQuery('#register #primary_assignment').empty();
			jQuery.each(result, function(key, value) {
				var selected = '';
				if (value.match(/Holding Chapter/)) {
					selected = ' selected';
				}
				jQuery('#register #primary_assignment').append('<option value="' + key + '"' + selected + '>' + value + '</option>');
			});
		});

		jQuery('#register #branch').change(function() {
			var branch = jQuery('#branch').val();
			jQuery.getJSON('/api/chapter/' + branch, function(result) {
				jQuery('#register #primary_assignment').empty();
				jQuery.each(result, function(key, value) {
					var selected = '';
					if (value.match(/Holding Chapter/)) {
						selected = ' selected';
					}
					jQuery('#register #primary_assignment').append('<option value="' + key + '"' + selected + '>' + value + '</option>');
				});
			});
		});

    };
};