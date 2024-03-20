$(document).ready(function (){
    console.log("PDP PAGE");

    let PDP = {
        init: function () {
            this.icon_list_init();
            this.our_customer_init();
        },

        icon_list_init: function () {
            let container = $('.pdp-icon_list');
            let list = $('.pdp-icon_list > .wp-block-group');
            console.log(list.length);
            let number = (list.length % 2 === 0) ? "even" : "odd";
            container.addClass(number);
        },

        our_customer_init: function () {
            let OC_slider = $('.pdp-testimonial_slider');
            let items = $('.pdp-testimonial_slider > div');
            let n = items.length;

            if (OC_slider && OC_slider.length > 0) {
                OC_slider.slick({
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    arrows: false,
                    autoplay: false,
                    infinite: false,
                    dots: n > 3,
                    centerPadding: '50px',
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                dots: n > 2,
                            }
                        },
                        {
                            breakpoint: 690,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                dots: n > 1,
                            }
                        }
                    ]
                });
            }
        }

    };

    PDP.init();

});