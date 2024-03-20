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
	$('#'+content_id).addClass('megamenu_mb_show');
});

$('.megamenu_mb .label').click(function(){
	var id = $(this).attr('id');
	content_id = id.replace('close_','sub_menu_');
	$('#'+content_id).removeClass('megamenu_mb_show');
});
