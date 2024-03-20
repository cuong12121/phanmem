$(document).ready(function(){
	 var width = $(window).width();
	  $(window).resize(function() {
	    width = $(window).width();
	  });

	// if(width < 990){
	// 	$('.field_item').click(function(e){
	// 		var check = $(this).find('.filters_in_field').hasClass('display-open');
	// 		$('.filters_in_field').removeClass('display-open');
	// 		if(check) {
	// 		}
	// 		else {
	// 		$(this).find('.filters_in_field').toggleClass('display-open');	
	// 		}
			
	// 		//alert('ffff');
	// 	});
	// }

	$('.block_products_filter .field_item .field_name .icon').click(function(e){
		var data = $(this).attr('data-name');
		$('#ft'+data).slideToggle('display_off');
		$(this).toggleClass('rotateam90deg');
		// alert(data);
	});
});	