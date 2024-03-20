$(document).ready(function(){	
    var swiper = new Swiper('.swiper-container', {
          slidesPerView: 4,
          slidesPerColumn: 4,
          spaceBetween: 5,
          autoplay: {
            delay: 5000,
            disableOnInteraction: false,
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          breakpoints: {
            // when window width is <= 320px
            320: {
              slidesPerView: 2,
              slidesPerColumn: 2,
              spaceBetween: 10
            },
            // when window width is <= 480px
            480: {
              slidesPerView: 2,
              slidesPerColumn: 2,
              spaceBetween: 20
            },
            // when window width is <= 640px
            640: {
              slidesPerView: 3,
              slidesPerColumn: 2,
              spaceBetween: 30
            }
          },
        });
});	