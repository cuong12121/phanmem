$(document).ready(function() {
   run_tab_str();
});

function run_tab_str(){
	$('.i_list_str').click(function(){
		var id = $(this).attr('id');
		$('.i_list_str').removeClass('active');
		$(this).addClass('active');
		content_id = id.replace('i_list_str_','img_str_');
		$('.item_str').fadeOut(1);
		//$('.content_pro').removeClass('c_yes');
		//$('.content_pro').addClass('c_no');
		//$('.content_pro').fadeOut();
		//$('.item').addClass('item_no');
		$('#'+content_id).fadeIn(1);
		//$('#'+content_id).removeClass('c_no');
		
		//$('#'+content_id).fadeIn();


	})
}