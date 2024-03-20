$(document).ready(function(){
	$('.product_grid_slide .item').removeClass('hide');
	$('.product_grid_slide .item').removeClass('item-block');
	var sync1 = $(".product_grid_slide");
	var flag = false;
	var duration = 300;
	sync1.owlCarousel({
		loop:true,
		nav:true,
		navText: [
		"‹",
		"›"
		],
		margin:0,
		dots:false,
		pagination:false,		      
		autoplay: true,
	      responsiveClass:true,
	      lazyLoad : true,
	      responsive:{
	      	0:{
	      		items:2,
	      	},
	      	500:{
	      		items:3,
	      	},
	      	800:{
	      		items:3,
	      	},
	      	1170:{
	      		items:4,
	      	}
	      }
	  })
});

