jQuery(document).ready(function () {
    console.log('main');

    jQuery('body').attr('data-load', 'success');

    let ContactPages = {
        init: function () {
            // this.scrollToTopPage();
        },

        /**
         * when the fields are not filled, move to the top of the filed to show the message.
         * (both desktop and mobile)
         */
        scrollToTopPage: function () {
            jQuery('.wpforms-form').on('submit', function (event) {
                // Check if form has errors
                setTimeout(() => {
                    let errors = jQuery('.wpforms-form').find('.wpforms-has-error');
                    if (errors.length > 0) {
                        // Get the position of the first error
                        let firstErrorPosition = errors.first().offset().top;
                        jQuery('html, body').animate({scrollTop: firstErrorPosition}, '500');
                    }
                }, 1000);
            });
        }
    }
    ContactPages.init();

});