 var owl = $('.partners .owl-carousel');
    owl.owlCarousel({
      items:8,
      loop:true,
      margin:9,
      autoplay:true,
      autoplayTimeout:3000,
      responsiveClass:true,
      responsive:{
        0:{
          items:2,
          nav:false
        },
        400:{
          items:3,
          nav:false
        },
        600:{
          items:4,
          nav:false
        },
        800:{
          items:6,
          nav:false
        },
        1170:{
          items:8,
          nav:false
        }
      },
      autoplayHoverPause:true
    });
    $('.partners .prev').click(function() {
      owl.trigger('prev.owl.carousel');
    })
    // Go to the previous item
    $('.partners .next').click(function() {
      // With optional speed parameter
      // Parameters has to be in square bracket '[]'
      owl.trigger('next.owl.carousel', [300]);
    });
