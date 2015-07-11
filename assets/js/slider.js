+(function ($) {
    "use strict";

    // owl Slider/Carousel
    var $slider = $('.owl-carousel.portfolio-slider'),
        defaultOptions = {
            items:1,
            autoWidth:false,
            autoHeight: true,
            loop:true,
            center:true,
            margin:10,
            URLhashListener:true,
            autoplay: true,
            autoplayHoverPause:true,
            startPosition: 'URLHash',
            dots: true
        },
        options = $slider.data('options');

    $slider.owlCarousel($.extend(defaultOptions, options));
}(window.jQuery);