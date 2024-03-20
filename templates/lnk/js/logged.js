$(document).ready( function(){
	$('.wrapper_children').hide();
//	$('li.item').hide();	
	item_active = $('li.active').parent();
	
	tag_containt = item_active.attr('id');

	if(tag_containt.indexOf("c_") >= 0){
		tag_parent = tag_containt.replace("c_", "pr_");
		$('#'+tag_parent).removeClass('plus').addClass('devision');
		item_active.show();
	}
});

$('.point_change').click(function(){
	item_id = $(this).attr('id');
	tag_containt = item_id.replace("pr_", "c_");
	if($(this).hasClass('plus')){
		$('#'+tag_containt).show();
		$(this).removeClass('plus').addClass('devision');
	} else {
		$('#'+tag_containt).hide();
		$(this).removeClass('devision').addClass('plus');
	}
});
