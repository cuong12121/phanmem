 var owl = $('.partners .owl-carousel');
    owl.owlCarousel({
      items:5,
      loop:true,
      margin:9,
      autoplay:true,
      autoplayTimeout:3000,
      responsiveClass:true,
      pagination:false,
      nav:true,
      dots:false,
       navText: [
		        "‹",
		        "›"
		        ],
			
      responsive:{
        0:{
          items:2,
        },
        400:{
          items:3,
        },
        600:{
          items:3,
        },
        800:{
          items:4,
        },
        1170:{
          items:5,
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
