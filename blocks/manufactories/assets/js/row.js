 var owl = $('.block-manufactories-row .owl-carousel');
    owl.owlCarousel({
      items:8,
      loop:true,
      // margin:9,
      autoplay:true,
      autoplayTimeout:3000,
      responsiveClass:true,
      pagination:false,
      nav:false,
      dots:false,
       margin:0,
      lazyLoad : true,
       navText: [
            "‹",
            "›"
            ],
      
      responsive:{
        0:{
          items:4,
          margin:5,
        },
        400:{
          items:4,
          margin:5,
        },
        600:{
          items:4,
          margin:5,
        },
        800:{
          items:4,
        },
        1170:{
          items:6,
        }
      },
      autoplayHoverPause:true
});
  
  
