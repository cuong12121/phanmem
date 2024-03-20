$(function() {
	$('#fs-slider .item').removeClass('hide');
		$('#fs-slider').owlCarousel({
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
		      autoplay: false,
			  autoplayTimeout:4000,
		      items:1,
		      lazyLoad : true
		  })
});
