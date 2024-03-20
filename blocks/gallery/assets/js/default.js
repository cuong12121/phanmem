 var owl = $('.testi_body .owl-carousel');
    owl.owlCarousel({
      loop:true,
      margin:15,
      autoplay:true,
      autoplayTimeout:2000,
      responsiveClass:true,
      pagination:false,
      nav:true,
      lazyLoad : true,
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
          items:4,
          margin: 30,
        }
      },
      autoplayHoverPause:true
    });
    $('.testi_body .prev').click(function() {
      owl.trigger('prev.owl.carousel');
    })
    // Go to the previous item
    $('.testi_body .next').click(function() {
      // With optional speed parameter
      // Parameters has to be in square bracket '[]'
      owl.trigger('next.owl.carousel', [300]);
    });
