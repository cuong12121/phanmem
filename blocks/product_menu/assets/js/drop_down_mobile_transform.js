$(document).ready(function(){	
	product_menu_mobile();
});	

function product_menu_mobile(){
	$('.bt_after').click(function(){
		var parent = $(this).parent();
		parent.removeClass('closed').addClass('opened');
		$(this).parent().parent().css('transform','translate(-90%,0)');
		// var current_id = $(this).attr('id');
		// var childrends_class = current_id.replace('li-menu_item_','child_of_');
		// console.log(childrends_class);
		// if($(this).hasClass('closed')){
		// 	$(this).removeClass("closed");
		// 	$(this).addClass("opened");
		// 	$('.'+childrends_class).slideToggle(200);
		// 	//$(this).next("ul").stop(true,true).show(200);
		// }else{
		// 	$(this).addClass("closed");
		// 	$(this).removeClass("opened");
		// 	//$(this).next("ul").hide(200);
		// 	$('.'+childrends_class).hide(200);
		// }
	});
	$('.bt_before').click(function(){
		$(this).parent().parent().parent().parent().removeClass('opened').addClass('closed');

		var parent = $(this).parent();
		parent.removeClass('closed').addClass('opened');
		$('.product_menu_ul_innner').css('transform','translate(-0,0)');
		// var current_id = $(this).attr('id');
		// var childrends_class = current_id.replace('li-menu_item_','child_of_');
		// console.log(childrends_class);
		// if($(this).hasClass('closed')){
		// 	$(this).removeClass("closed");
		// 	$(this).addClass("opened");
		// 	$('.'+childrends_class).slideToggle(200);
		// 	//$(this).next("ul").stop(true,true).show(200);
		// }else{
		// 	$(this).addClass("closed");
		// 	$(this).removeClass("opened");
		// 	//$(this).next("ul").hide(200);
		// 	$('.'+childrends_class).hide(200);
		// }
	});
}
