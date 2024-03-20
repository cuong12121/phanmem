$(function() {  
    $('.list_certifications_slide .box_items').owlCarousel({
          loop:true,
          nav:true,
          
          navText: [
            "‹",
            "›"
            ],
          dots:true,
          pagination:true,
          autoplay: false,
          autoplayTimeout:5000,
          items:1,
          center: true,
          lazyLoad : true,
          smartSpeed: 500,
          responsive:{
            0:{
                  items:1,
                  margin:0,
              },        
             500:{
                  items:1,
                   margin:0,
              }           
          }
      })
});