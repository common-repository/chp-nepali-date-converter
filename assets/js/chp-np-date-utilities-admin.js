window.onload = function() {
    if (window.jQuery) {  
        toggleinput();
        // jQuery is loaded
        jQuery(document).on('click', '#myonoffswitch', function () {
            toggleinput();
        });

        // jQuery is loaded
        jQuery(document).on('click', '#commentSwitch', function () {
            toggleinput();
        });

        /**
         * change value to hidden field
         */
        jQuery(document).on('click change keyup keydown copy paste', '#chp_date_format_2', function () {
            var value = jQuery(this).val();
            jQuery('#chp_date_format_1').val(value);
        });
    }
}

function toggleinput() {
    if (jQuery('#myonoffswitch').is(':checked')) {
        jQuery('.chp-css-input').attr('readonly', false);
    } else {
        jQuery('.chp-css-input').attr('readonly', true);
    }
}