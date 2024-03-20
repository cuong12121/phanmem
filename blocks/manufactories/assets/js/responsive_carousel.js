$(function() {
	var timeout = $('#timeout_partner').val();
	var timeout = timeout+'00';
	
	var rotate = $('#is_auto_partner').val();
	if(rotate == '0')
		rotate = false;
	else
		rotate = true;
	
	$('.block-partners #carousel').carouFredSel({
		width: '100%',
	 	auto: rotate,
	    prev: ".block-partners #prev",
	    next: ".block-partners #next",
	    scroll: { items:1,duration: timeout},
	    mousewheel: true
	   
	});

});