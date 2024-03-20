$(".level1").click(function () {
	if($(this).hasClass('open')){
		$(this).children('ul').slideToggle(600);;
		$(this).removeClass('open').addClass('close');
	}else{
		$(this).children('ul').slideToggle(600);;
		$(this).removeClass('close').addClass('open');
	}
});
