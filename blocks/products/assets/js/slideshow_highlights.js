$(function() {
//	$('#products_blocks_slideshow_hot_new .owl-carousel').owlCarousel({
//	      loop:true,
//	      nav:false,
//	      items:1,
//	      dots:true,
//	      autoplay: true
//	  })
		
//	$('.products_blocks_wrapper').removeClass('hide');
//	
	$('.products_blocks_slideshow_hot').each(function( index ) {
		var id_block = $(this).attr('id');
		var identity = id_block.replace('products_blocks_slideshow_hot_','');
		$('#products_blocks_slideshow_hot_'+identity+'').owlCarousel({
		      loop:true,
		      nav:true,
		      nav:true,
		      navText: [
		        "&nbsp;",
		        "&nbsp;"
		        ],
		      dots:false,
		      pagination:false,
		      autoplayTimeout:10000,
			  loop: true,		      
		      autoplay: false,
		      responsiveClass:true,
		      responsive:{
		          0:{
		              items:1,
		          },
		          600:{
		              items:2,
		          },
		          1000:{
		              items:3,
		          }
		      }
		  })
	});
});
