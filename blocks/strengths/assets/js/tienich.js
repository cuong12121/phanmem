$(document).ready(function() {
   run_tab_str_tienich();
});

function run_tab_str_tienich(){
	$('.menu_item_str').click(function(){
		var id = $(this).attr('id');
		$('.menu_item_str').removeClass('active');
		$(this).addClass('active');
		content_id = id.replace('li_str_','content_str_');
		$('.content_str').removeClass('c_yes');
		$('.content_str').addClass('c_no');
		//$('.content_str').fadeOut();
		//$('.item').addClass('item_no');
		$('#'+content_id).removeClass('c_no');
		$('#'+content_id).addClass('c_yes');
		$('#'+content_id).fadeIn(2000);


	})
}