$('.menu_show').click(function(){
    $('.megamenu_mb').toggleClass('megamenu_mb_show');
    $('.modal-menu-full-screen-menu').addClass('show_screen');
});

$('.close_all').click(function(){
    $('.megamenu_mb').toggleClass('megamenu_mb_show');
    $('.highlight').removeClass('megamenu_mb_show');
    $('.modal-menu-full-screen-menu').removeClass('show_screen');

});


$('.megamenu_mb .next_menu').click(function(){
	var id = $(this).attr('id');
	content_id = id.replace('next_','sub_menu_');
	//$('#'+content_id).addClass('megamenu_mb_show');
	//$('.level_0 .highlight ').addClass('');
	$('#'+content_id).slideToggle();
	$(this).toggleClass('active');
	//alert(content_id);

	// if (!$('#'+content_id).hasClass("deactive")){
	// 	//alert('a');
	// 	$('#'+content_id).slideToggle();

	// 	$('.level_0 .highlight').addClass("deactive");
	// 	$('#'+content_id).removeClass("deactive");

	// }else {
	// 	//alert('b');
	// 	$(".level_0 .highlight").addClass("deactive");
	// 	$('#'+content_id).removeClass("deactive");
	// 	if ($('#'+content_id).is(":hidden")) {
	// 		$('#'+content_id).slideToggle();
	// 	}

	// }


	// if (!$(this).hasClass("deactive")) {
	// 	$(".element-toggle").slideToggle();
	// 	$(".div1").addClass("deactive");
	// 	$(this).removeClass("deactive");
	// }
	// else {
	// 	$(".div1").addClass("deactive");
	// 	$(this).removeClass("deactive");
	// 	if ($(".element-toggle").is(":hidden")) {
	// 		$(".element-toggle").slideToggle();
	// 	}

	// }

});


