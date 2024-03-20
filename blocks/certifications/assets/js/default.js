$(function() {	
	$('.box_items_sli').owlCarousel({
		loop:true,
		nav:true,	      
		navText: [
        	"‹",
        	"›"
        ],
		dots:false,
		pagination:true,
		autoplay: false,
		autoplayTimeout:3000,
		items:1,
		center: true,
		lazyLoad : true,
		smartSpeed: 1000,
		margin:10,
		responsive:{
			0:{
	            items:3,
	            nav:true,
	            margin:20
	        },
			650:{
	            items:3,
	            nav:true,
	        },		          
	       	1000:{
	            items:5,
	            nav:true,
	        }	         
	    }
	})
});