$(document).ready(function () {

    $('.slider-slick_posts').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: true,
        autoplay: false,
        dots: true,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true
                }
            },
            {
                breakpoint: 690,
                settings: {
                    dots: false,
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // Product Listing Page
    let PLP = {
        classes: {
            PLP_cat_section: 'plp-category_section',
            PLP_cat_slick: 'plp-category_slick',
        },

        init: function () {
            $('p:empty').remove();
            this.init_category_slick();
        },

        init_category_slick: function () {
            let _this = this;
            let sliders = $('.' + _this.classes.PLP_cat_slick);

            if (sliders && sliders.length > 0) {
                sliders.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: false,
                    dots: false,
                    mobileFirst: true,
                    infinite: false,
                    variableWidth: true,
                });
            }
        }
    };

    PLP.init();
});