"use strict";

jQuery(document).ready(function () {
    console.log("mpRegister.js 2");

    /**
     * Register Form in Register page
     */
    let register = {
        form: {
            firstname: '#user_first_name1',
            lastname: '#user_last_name1',
            username: '#user_login1',
            email: '#user_email1',
            password: '#mepr_user_password1',
            confirmPass: '#mepr_user_password_confirm1'
        },

        init: function () {
            this.formInit();
            this.listenPasswordIsTyped();
        },

        formInit: function () {
            let _this = this;
            // Change placeholder
            jQuery(_this.form.firstname).attr('placeholder', 'First Name');
            jQuery(_this.form.lastname).attr('placeholder', 'Last Name');
            jQuery(_this.form.username).attr('placeholder', 'Username');
            jQuery(_this.form.email).attr('placeholder', 'Email');
            jQuery(_this.form.password).attr('placeholder', 'Password');
        },

        listenPasswordIsTyped: function () {
            let _this = this;
            jQuery(_this.form.password).change(function () {
                let value = jQuery(this).val();
                console.log(value);
                jQuery(_this.form.confirmPass).val(value);
            });
        }

    };

    register.init();

});