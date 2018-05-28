module.exports = function() {
    this.initRegisterForm = function () {
        jQuery.each(['country', 'branch', 'primary_assignment'], function (key, control) {
            jQuery('#' + control).selectize({
                sortField: 'text',
                lockOptgroupOrder: true
            });
        });
    };
};