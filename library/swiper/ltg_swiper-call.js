$(document).ready(function () {
    //initialize swiper when document ready
    
        var swiperFeaturedBilder = new Swiper ('.swiper-featured-galerie', {
            // Optional parameters
            slidesPerView: 'auto',
            spaceBetween: 0,
            loop: true,
            slidesPerGroup:1,
            speed:2000,
            effect:'fade',
            autoplay: {
                delay: 4000,
            },
            pagination: {
               el: '.swiper-pagination',
               clickable: true,
            },
        
        })
        
        var swiperHaendlerBilder = new Swiper ('.swiper-galerie', {
            // Optional parameters
            slidesPerView: 'auto',
            spaceBetween: 16,
            loop: true,
            slidesPerGroup:1,
            speed:10000,
            autoplay: {
                delay: 1,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        })
        
    
    });