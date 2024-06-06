"use strict";

jQuery(document).ready(function () {
    console.log("mpAccount.js");

    let account = {
        j: {
            subscriptionTable: '#MeprAccount-SubscriptionTable'
        },

        init: function () {
            this.preInit();
            this.triggerClickClosePopup();
            // this.getCardType();
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
        },

        getCardType: async function () {
            // let _this = this;
            // let action = this.getUrlParameter('action');
            //
            // if (action === 'subscriptions') {
            //     let id = 'ch_3PLkWb06ts71dmvX0AOHZukR';
            //
            //     let pubKey = jQuery(_this.j.subscriptionTable).attr('data-sk');
            //     let sKey = '';
            //
            //     // Construct the URL
            //     var stripe = Stripe(pubKey);
            //     var elements = stripe.elements({
            //         clientSecret: sKey,
            //     });
            // }
        }
    };

    account.init();

});