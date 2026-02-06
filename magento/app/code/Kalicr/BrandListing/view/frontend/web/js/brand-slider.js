define([
    'jquery',
    'slick'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).slick({
            dots: false,
            infinite: true,
            speed: 400,
            slidesToShow: config.slidesToShow || 5,
            slidesToScroll: 1,
            autoplay: config.autoplay || false,
            autoplaySpeed: 3000,
            arrows: true,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 4 } },
                { breakpoint: 768, settings: { slidesToShow: 3 } },
                { breakpoint: 480, settings: { slidesToShow: 2 } }
            ]
        });
    };
});