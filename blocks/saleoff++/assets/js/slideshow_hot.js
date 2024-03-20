$(document).ready(function(){
	$('.slideshow-hot-list .item').removeClass('hide');
	$('.slideshow-hot-list .item').removeClass('item-block');
	var sync1 = $(".slideshow-hot-list");
	var flag = false;
	var duration = 300;
	sync1.owlCarousel({
		loop:true,
		nav:true,
		navText: [
		"‹",
		"›"
		],
		margin:14,
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
				items:5,
			}
		}
	})
});

