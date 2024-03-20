$(document).ready(function(){
        var owl = $("#block-tesimonials");
        owl.owlCarousel({
            loop:true,
	    responsiveClass:true,
		navText:[ "",""],
		
				nav:true,
				loop:false,
				dots:true,
				responsive:{
		          0:{
		              items:1,
		          },
		         
		          700:{
		              items:2,
		          }
		      }	        

        });
        // Custom Navigation Events
});

