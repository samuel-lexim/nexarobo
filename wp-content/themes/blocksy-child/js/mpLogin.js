"use strict";

jQuery(document).ready(function () {
    console.log("mpLogin.js");

    /**
     * Login Form
     */
    let login = {
        init: function () {
            this.formInit();
        },

        formInit: function () {
            // Change placeholder
            jQuery('input[name="log"][id="user_login"]').attr('placeholder', 'Email');
            jQuery('input[name="pwd"][id="user_pass"]').attr('placeholder', 'Password');

            // Add "Or"
            jQuery('.mepr-login-actions').prepend("<p class='or'>or</p>");
        }
    };

    login.init();

});