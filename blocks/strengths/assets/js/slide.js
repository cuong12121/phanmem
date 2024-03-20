$(document).ready(function() {
   run_tab_str();
});

function run_tab_str(){
	$('.item-label').click(function(){
		var id = $(this).attr('id');
		//$('.tab_title li').removeClass('activated');
		//$(this).addClass('activated');
		content_id = id.replace('tab_str_','item_str_');
		bg_id = id.replace('item_str_','item_bg_');

		$('.item_bg').addClass('hide');
		$('#'+bg_id).removeClass('hide');

		$('.item').removeClass('item_yes');
		$('.item').addClass('item_no');
		$('#'+content_id).removeClass('item_no');
		$('#'+content_id).addClass('item_yes');
	})
}