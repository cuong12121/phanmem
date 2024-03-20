$(function() {
	$('#sell_gird').owlCarousel({
		loop:true,
		nav:true,
		nav:true,
		navText: [
		"‹",
		"›"
		],
		dots:false,
		pagination:true,
		dots: true,
		autoplay: true,
		autoplayTimeout:3000,
		items:4,
		lazyLoad : true,
		responsive : {
			0 : {
				items : 2,
			},
			480 : {
				items : 2,
			},
			768 : {
				items : 3,
			},			
			1024 : {
				items : 4,
			}
		}
	})
});
