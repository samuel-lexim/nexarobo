jQuery(document).ready(function () {
    console.log('PLP.js');

    // Product Listing Page
    let PLP = {
        classes: {
            PLP_cat_section: 'plp-category_section',
            PLP_cat_slick: 'plp-category_slick',
        },

        init: function () {
            jQuery('p:empty').remove();
            this.init_category_slick();
        },

        init_category_slick: function () {
            let _this = this;
            let sliders = jQuery('.' + _this.classes.PLP_cat_slick);

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

                // Check arrow
                let plpSliders = jQuery('.' + _this.classes.PLP_cat_slick + '.topRightArrow');
                for (let key in plpSliders) {
                    if (plpSliders.hasOwnProperty(key) && parseInt(key) >= 0) {
                        let item = plpSliders[key];
                        let _item = jQuery(item);
                        let findArrows = _item.find('.slick-arrow');
                        if (findArrows && findArrows.length <= 0) {
                            _item.addClass("noArrows");
                        }
                    }
                }
            }
        }
    };
    PLP.init();

});