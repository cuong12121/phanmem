$(document).ready(function () {
	$(function() {
		$('.block-gallery-slide2 .owl-carousel').owlCarousel({
		      loop:true,
		      nav:true,
		      navText: [
		        "‹",
		        "›"
		        ],
		      dots:false,
		      pagination:false,
		      autoplay: false,
			  autoplayTimeout:4000,
		      items:1,
		      center: true,
		      lazyLoad : true,
		      itemsScaleUp : false
		});
	});
});