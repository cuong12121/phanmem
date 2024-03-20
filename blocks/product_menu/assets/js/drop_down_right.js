expand_filter();
$(document).ready(function(){
	
//	product_menu();
});	
function expand_filter(){
	if($('.menu_label').hasClass('product_menu_home'))
		return;
	$('.product_menu').hover(function(e){
//		var id = $(this).find('.menu_label').attr('data-id');
		$(this).find('.menu_label').toggleClass( "active" );
		$('#product_menu_ul').toggle();
	});
}
//function product_menu(){
//	$('.li-product-menu-item').click(function(){
//		var current_id = $(this).attr('id');
//		var childrends_class = current_id.replace('li-menu_item_','child_of_');
//		console.log(childrends_class);
//		if($(this).hasClass('closed')){
//			$(this).removeClass("closed");
//			$(this).addClass("opened");
//			$('.'+childrends_class).slideToggle(200);
//			//$(this).next("ul").stop(true,true).show(200);
//		}else{
//			$(this).addClass("closed");
//			$(this).removeClass("opened");
//			//$(this).next("ul").hide(200);
//			$('.'+childrends_class).hide(200);
//		}
//	});
//}
