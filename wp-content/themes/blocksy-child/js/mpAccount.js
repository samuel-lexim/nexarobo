"use strict";


jQuery(document).ready(function () {
    console.log("mpAccount.js");


    let account = {

        init: function () {
            this.preInit();
            this.triggerClickClosePopup();
        },

        preInit: function () {
            let action = this.getUrlParameter('action');
            action = action ? action : 0;
            jQuery('body').attr('action', action);

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
        },

        triggerClickClosePopup: function () {
            jQuery('.mf-toggle-close').click(function () {
                jQuery('.mfp-close').trigger("click");
            });
        }
    };

    account.init();

});