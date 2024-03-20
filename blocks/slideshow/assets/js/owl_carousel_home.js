$(function() {
		$('.fs-slider-home_slide .item').removeClass('hide');
		$('.fs-slider-home_slide .item').removeClass('active2');
		$('.fs-slider-home_slide').owlCarousel({
		      loop:true,
		      nav:true,
		      
		      navText: [
		        "",
		        ""
		        ],
		      dots:true,
		      pagination:true,
		      autoplay: true,
			  autoplayTimeout:5000,
		      items:1,
		      center: true,
		      lazyLoad : true,
		      smartSpeed: 500,
		      responsive:{
		         0:{
		              items:1,
		              margin:0,
		              nav:false,
		          },
		          
		       
		         500:{
		              items:1,
		               margin:0,
		               nav:true,
		          }
		         
		      }
		  })
});
$('.introduce').removeClass('introduce_js');