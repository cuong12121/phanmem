$(document).ready(function(){
	$('.slideshow-hot-list .item').removeClass('hide');
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
	      margin:10,
	      dots:false,
	      pagination:false,		      
	      autoplay: false,
	      margin:10,
	      responsiveClass:true,
	      lazyLoad : true,
	      responsive:{
	          0:{
	              items:3,
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

