$(document).ready(function () {
  $(function() {
  
  $('.owl-partners-wrapper').owlCarousel({
        loop:true,
        nav:true,
        
        navText: [
          "‹",
          "›"
          ],
        dots:false,
        pagination:false,
        autoplay: true,
        autoplayTimeout:4000,
        items:4,
        
        lazyLoad : true,
        itemsScaleUp : false,
         // responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
   })
  });


});