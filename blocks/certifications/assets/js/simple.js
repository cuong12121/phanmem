 var owl = $('.partners .owl-carousel');
    owl.owlCarousel({
      items:8,
      loop:true,
      margin:9,
      autoplay:false,
      autoplayTimeout:3000,
      responsiveClass:true,
      pagination:false,
      nav:true,
      dots:false,
       navText: [
		        "&nbsp;",
		        "&nbsp;"
		        ],
			
      responsive:{
        0:{
          items:2,
        },
        400:{
          items:3,
        },
        600:{
          items:4,
        },
        800:{
          items:6,
        },
        1170:{
          items:8,
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
