$(document).ready(function(){
        var owl = $("#block-customer");
        owl.owlCarousel({
            loop:true,
	    responsiveClass:true,
		  navText: [
		        "‹",
		        "›"
		        ],
		responsive:{
			0:{
				items:1,
				nav:false,
				dots:true
			},
			600:{
				items:1,
				nav:false,
				dots:true
			},
			1000:{
				items:1,
				nav:true,
				loop:false,
				dots:false
			}
		}
        });
        // Custom Navigation Events
});

