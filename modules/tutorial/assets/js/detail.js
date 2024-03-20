$( document ).ready(function() {

	$('.tutorial_tabs_body .tab_item').click(function(){
		var height = $('.header_wrapper_wrap_body').height();
		height = height + 30;
		var id = $(this).attr('id');
		content_id = id.replace('tab_item_','elementor_section_');

		$('html, body').animate({
	      scrollTop: $("#"+content_id).offset().top - height
	    }, 1000);
	});
});

