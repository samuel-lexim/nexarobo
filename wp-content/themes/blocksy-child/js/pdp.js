$(document).ready(function (){
    console.log("PDP PAGE");

    let PDP = {
        init: function () {
            this.icon_list_init();
        },

        icon_list_init: function () {
            let container = $('.pdp-icon_list');
            let list = $('.pdp-icon_list > .wp-block-group');
            console.log(list.length);
            let number = (list.length % 2 === 0) ? "even" : "odd";
            container.addClass(number);
        }
    };

    PDP.init();

});