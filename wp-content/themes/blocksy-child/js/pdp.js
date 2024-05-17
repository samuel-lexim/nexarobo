"use strict";

jQuery(document).ready(function () {
    console.log("PDP new");

    let PDP = {
        classes: {
            gallery_slick: 'slick-gallery',
            gallery_thumb_slick: 'slick_gallery_thumbs',
            left_gallery: 'pdp-left_gallery',
            ourCustomer_slider: 'pdp-testimonial_slider'
        },

        init: function () {
            let _this = this;
            this.icon_list_init();
            this.our_customer_init();
            this.disableTagLink();
            this.resize();
            _this._toggleExpandedWhenClickedReviews();
        },

        gallery_init: function () {
            let _this = this;
            const galleryItems = jQuery("." + _this.classes.gallery_slick + ' > *');
            const thumbsSlider = jQuery('<div class="blackArrow ' + _this.classes.gallery_thumb_slick + '"></div>');

            const ids = Array.from(Array(galleryItems.length).keys());
            const promises = ids.map(
                id => _this.gallery_getThumbFromGalleryItem(galleryItems[id])
            );

            Promise.all(promises)
            .then(results => {
                thumbsSlider.append(results);
                jQuery("." + _this.classes.gallery_slick).after(thumbsSlider);
                jQuery('.' + _this.classes.gallery_slick).removeClass('showOnlyFirst');
                _this.gallery_slider_init();
            })
            .catch(error => {
                console.error("Error:", error);
            });
        },

        gallery_getThumbFromGalleryItem: function (item) {
            let _this = this;
            return new Promise((resolve, reject) => {
                let _item = jQuery(item);
                let thumbUrl = null;
                let classArray = _item.attr('class');
                if (classArray) {
                    classArray = classArray.split(" ");
                }
                let _type = '_img';

                if (jQuery.inArray('wp-block-embed', classArray) !== -1) { // video
                    _type = '_video';
                    let iframeSrc = _item.find('iframe').attr('src');
                    let type = 0;
                    type = jQuery.inArray('is-provider-youtube', classArray) !== -1 ? 1 : type;
                    type = jQuery.inArray('is-provider-vimeo', classArray) !== -1 ? 2 : type;
                    thumbUrl = _this.getYoutubeVimeoThumbnail(iframeSrc, type);
                    let thumbsSliderHtml = '<div class="_navThumb ' + _type + '">' +
                        '<div class="_navThumbInner">';
                    thumbsSliderHtml += thumbUrl ? '<img src="' + thumbUrl + '" alt="thumb">' : '';
                    thumbsSliderHtml += '</div></div>';
                    resolve(thumbsSliderHtml);

                } else if (jQuery.inArray('stk-block-image', classArray) !== -1) { // image
                    _type = '_img';
                    thumbUrl = _item.find('img').attr('src');

                    // Extract the image ID from the full image URL
                    let matches = thumbUrl.match(/wp-content\/uploads\/(\d{4}\/\d{2})\/(.+)$/);
                    if (!matches || matches.length < 3) {
                        reject('Invalid image URL format');
                    }
                    let imageYearMonth = matches[1];
                    let imageName = matches[2];
                    let originUrl = window.location.origin;

                    // Make a request to Wordpress REST API to get the thumbnail URL
                    fetch(`${originUrl}/wp-json/wp/v2/media?search=${imageName}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Find the thumbnail size URL from the API response
                        for (const media of data) {
                            if (media.media_details.sizes.thumbnail && media.media_details.file.includes(imageYearMonth)) {
                                thumbUrl = media.media_details.sizes.thumbnail.source_url;
                                let thumbsSliderHtml = '<div class="_navThumb ' + _type + '">' +
                                    '<div class="_navThumbInner"><img src="' + thumbUrl + '" alt="thumb"></div></div>';
                                resolve(thumbsSliderHtml);
                                return;
                            }
                        }
                        reject(`Thumbnail not found for the image. ${thumbUrl}`);
                    })
                    .catch(error => {
                        reject(error);
                    });
                }
            });
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
                if (embedUrl) {
                    match = embedUrl.match(/\/embed\/([^?]+)/);
                    if (match && match[1]) {
                        videoId = match[1];
                        thumb = `https://i3.ytimg.com/vi/${videoId}/hqdefault.jpg`;
                    }
                } else {
                    console.error("Error embedUrl Youtube");
                }
            } else if (type === 2) { // Vimeo
                if (embedUrl) {
                    match = embedUrl.match(/\/(\d+)\?/);
                    if (match && match[1]) {
                        videoId = match[1];
                        thumb = `https://vumbnail.com/${videoId}.jpg`;
                    }
                } else {
                    console.error("Error embedUrl Vimeo");
                }
            }
            return thumb;
        },

        gallery_slider_init: function () {
            let _this = this;
            jQuery("." + _this.classes.gallery_slick).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: false,
                infinite: false,
                mobileFirst: true,
                asNavFor: "." + _this.classes.gallery_thumb_slick
            });

            jQuery("." + _this.classes.gallery_thumb_slick).slick({
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

        disableTagLink: function () {
            let tags = jQuery('.taxonomy-post_tag a');
            tags.removeAttr('href');
        },

        icon_list_init: function () {
            let container = jQuery('.pdp-icon_list');
            let list = jQuery('.pdp-icon_list > .wp-block-group');
            let number = (list.length % 2 === 0) ? "even" : "odd";
            container.addClass(number);
        },

        our_customer_init: function () {
            let _this = this;
            let OC_slider = jQuery('.' + _this.classes.ourCustomer_slider);
            let items = jQuery('.' + _this.classes.ourCustomer_slider + ' > div');
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
            let maxHeight = jQuery(window).width() > 690 ? 280 : 250;
            let padding = jQuery(window).width() > 690 ? 97 : 109;
            // console.log(`maxHeight: ${maxHeight} - Padding: ${padding}`);
            let OC_slider = jQuery('.' + _this.classes.ourCustomer_slider);
            let items = OC_slider.find('.slick-slide');
            items.each(function (i, e) {
                let _innerContent = jQuery(e).find('.gspb_container');
                let totalHeight = 0;
                _innerContent.children().each(function () {
                    totalHeight += jQuery(this).outerHeight(true);
                });
                if ((totalHeight + padding) > maxHeight) {
                    jQuery(e).addClass('hasThreeDots').removeClass('expanded');
                } else {
                    jQuery(e).removeClass('hasThreeDots').removeClass('expanded');
                }
            });

            // Add click event for each item
            _this._toggleExpandedWhenClickedReviews();
        },

        _toggleExpandedWhenClickedReviews: function () {
            let _this = this;
            // Add click event for each item
            jQuery('.' + _this.classes.ourCustomer_slider + ' .slick-slide').click(function () {
                jQuery(this).toggleClass('expanded');
            });
        },

        resize: function () {
            let _this = this;
            jQuery(window).resize(function () {
                _this.our_customer_expand_event();
                _this._toggleExpandedWhenClickedReviews();
            });
            _this._toggleExpandedWhenClickedReviews();
        },

    };

    PDP.gallery_init();
    PDP.init();

});