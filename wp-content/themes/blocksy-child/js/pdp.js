"use strict";

$(document).ready(function () {
    console.log("PDP PAGE");

    let PDP = {
        classes: {
            gallery_slick: 'slick-gallery',
            gallery_thumb_slick: 'slick_gallery_thumbs',
            left_gallery: 'pdp-left_gallery',
            ourCustomer_slider: 'pdp-testimonial_slider'
        },

        init: function () {
            let _this = this;
            this.gallery_init().then(() => {
                $('.' + _this.classes.gallery_slick).removeClass('showOnlyFirst');
                _this.gallery_slider_init();
            });
            this.icon_list_init();
            this.our_customer_init();
            this.disableTagLink();
            this.resize();
            _this._toggleExpandedWhenClickedReviews();
        },

        gallery_init: async function () {
            let _this = this;
            let html = await _this.gallery_thumb_init();
            $("." + _this.classes.gallery_slick).after(html);
        },

        gallery_thumb_init: async function () {
            let _this = this;
            let galleryItems = $("." + _this.classes.gallery_slick + ' > *');

            let thumbsSliderHtml = '<div class="blackArrow ' + _this.classes.gallery_thumb_slick + '">';
            for (let key in galleryItems) {
                if (galleryItems.hasOwnProperty(key) && parseInt(key) >= 0) {
                    let _type = '_img';
                    let item = galleryItems[key];
                    let _item = $(item);
                    let thumbUrl = null;
                    let classArray = _item.attr('class');
                    if (classArray) {
                        classArray = classArray.split(" ");
                    }

                    if ($.inArray('wp-block-embed', classArray) !== -1) { // video
                        _type = '_video';
                        let iframeSrc = _item.find('iframe').attr('src');
                        let type = 0;
                        type = $.inArray('is-provider-youtube', classArray) !== -1 ? 1 : type;
                        type = $.inArray('is-provider-vimeo', classArray) !== -1 ? 2 : type;
                        thumbUrl = _this.getYoutubeVimeoThumbnail(iframeSrc, type);

                    } else if ($.inArray('stk-block-image', classArray) !== -1) { // image
                        _type = '_img';
                        thumbUrl = _item.find('img').attr('src');
                        thumbUrl = await _this.getThumbnailUrl(thumbUrl);
                    }

                    // show correct thumbUrl async
                    thumbsSliderHtml += '<div class="_navThumb ' + _type + '">' +
                        '<div class="_navThumbInner"><img src="' + thumbUrl + '" alt="thumb"></div></div>';

                }
            } // End for

            thumbsSliderHtml += '</div>';
            return thumbsSliderHtml;
        },

        /**
         * Youtube embed: https://www.youtube.com/embed/dsT5p5c4LCg?feature=oembed
         * Vimeo embed: https://player.vimeo.com/video/119941062?dnt=1&app_id=122963
         * @param embedUrl
         * @param type | 1: youtube, 2: vimeo
         * @returns {null}
         */
        getYoutubeVimeoThumbnail: function (embedUrl, type = 0) {
            let match = null;
            let videoId = null;
            let thumb = null;
            if (type === 1) { // youtube
                match = embedUrl.match(/\/embed\/([^?]+)/);
                if (match && match[1]) {
                    videoId = match[1];
                    thumb = `https://i3.ytimg.com/vi/${videoId}/hqdefault.jpg`;
                }
            } else if (type === 2) { // Vimeo
                match = embedUrl.match(/\/(\d+)\?/);
                if (match && match[1]) {
                    videoId = match[1];
                    thumb = `https://vumbnail.com/${videoId}.jpg`;
                }
            }
            return thumb;
        },

        gallery_slider_init: function () {
            let _this = this;
            $("." + _this.classes.gallery_slick).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: false,
                infinite: false,
                mobileFirst: true,
                asNavFor: "." + _this.classes.gallery_thumb_slick
            });

            $("." + _this.classes.gallery_thumb_slick).slick({
                slidesToShow: 1,
                asNavFor: "." + _this.classes.gallery_slick,
                dots: false,
                arrows: false,
                infinite: false,
                mobileFirst: true,
                focusOnSelect: true,
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 690,
                        settings: {
                            arrows: true,
                        }
                    },
                ]
            });
        },

        /**
         * Get the thumbnail from the full image url in WP
         * @param fullImageUrl
         * @returns {Promise<null>}
         */
        getThumbnailUrl: async function (fullImageUrl) {
            // Extract the image ID from the full image URL
            let matches = fullImageUrl.match(/wp-content\/uploads\/(\d{4}\/\d{2})\/(.+)$/);
            if (!matches || matches.length < 3) {
                console.error('Invalid image URL format');
                return null;
            }
            let imageYearMonth = matches[1];
            let imageName = matches[2];
            let originUrl = window.location.origin;

            // Make a request to Wordpress REST API to get the thumbnail URL
            let response = await fetch(`${originUrl}/wp-json/wp/v2/media?search=${imageName}`);
            let data = await response.json();

            // Find the thumbnail size URL from the API response
            for (const media of data) {
                if (media.media_details.sizes.thumbnail && media.media_details.file.includes(imageYearMonth)) {
                    return media.media_details.sizes.thumbnail.source_url;
                }
            }

            console.error(`Thumbnail not found for the image. ${fullImageUrl}`);
            return null;
        },

        disableTagLink: function () {
            let tags = $('.taxonomy-post_tag a');
            tags.removeAttr('href');
        },

        icon_list_init: function () {
            let container = $('.pdp-icon_list');
            let list = $('.pdp-icon_list > .wp-block-group');
            let number = (list.length % 2 === 0) ? "even" : "odd";
            container.addClass(number);
        },

        our_customer_init: function () {
            let _this = this;
            let OC_slider = $('.' + _this.classes.ourCustomer_slider);
            let items = $('.' + _this.classes.ourCustomer_slider + ' > div');
            let n = items.length;

            if (OC_slider && OC_slider.length > 0) {

                OC_slider.on('init.slick', function (event, slick) {
                    _this.our_customer_expand_event();
                });

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
        },

        our_customer_expand_event: function () {
            let _this = this;
            let maxHeight = $(window).width() > 690 ? 280 : 250;
            let padding = $(window).width() > 690 ? 97 : 109;
            // console.log(`maxHeight: ${maxHeight} - Padding: ${padding}`);
            let OC_slider = $('.' + _this.classes.ourCustomer_slider);
            let items = OC_slider.find('.slick-slide');
            items.each(function (i, e) {
                let _innerContent = $(e).find('.gspb_container');
                let totalHeight = 0;
                _innerContent.children().each(function () {
                    totalHeight += $(this).outerHeight(true);
                });
                if ((totalHeight + padding) > maxHeight) {
                    $(e).addClass('hasThreeDots').removeClass('expanded');
                } else {
                    $(e).removeClass('hasThreeDots').removeClass('expanded');
                }
            });

            // Add click event for each item
            _this._toggleExpandedWhenClickedReviews();
        },

        _toggleExpandedWhenClickedReviews: function () {
            let _this = this;
            // Add click event for each item
            $('.' + _this.classes.ourCustomer_slider + ' .slick-slide').click(function () {
                $(this).toggleClass('expanded');
            });
        },

        resize: function () {
            let _this = this;
            $(window).resize(function () {
                _this.our_customer_expand_event();
                _this._toggleExpandedWhenClickedReviews();
            });
            _this._toggleExpandedWhenClickedReviews();
        },

    };

    PDP.init();

});