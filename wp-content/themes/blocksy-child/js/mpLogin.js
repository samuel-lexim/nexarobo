"use strict";

jQuery(document).ready(function () {
    console.log("mpLogin.js");

    /**
     * Login Form
     */
    let login = {
        passRecoveryForm: {
            email: '#mepr_user_or_email'
        },

        init: function () {
            this.formInit();
            this.forgotPasswordInit();
        },

        formInit: function () {
            // Change placeholder
            jQuery('input[name="log"][id="user_login"]').attr('placeholder', 'Email');
            jQuery('input[name="pwd"][id="user_pass"]').attr('placeholder', 'Password');

            // Add "Or"
            jQuery('.mepr-login-actions').prepend("<p class='or'>or</p>");
        },

        forgotPasswordInit: function () {
            console.log("forgotPasswordInit");
            let _this = this;
            let action = this.getUrlParameter('action');
            if (action && action === 'forgot_password') {
                jQuery('body').addClass('_passwordRecovery');
                jQuery(_this.passRecoveryForm.email).attr('placeholder', 'Your Email');
            } else {
                jQuery('body').removeClass('_passwordRecovery');
            }

        },

        getUrlParameter: function (sParam) {
            let sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        }
    };

    login.init();

});