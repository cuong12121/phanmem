// $("#content-1").slideDown();
// $("#click-aq-1").removeClass('plus');
// $("#click-aq-1").addClass('minus');
 

$(".question").click(function(event) {
	$(this).next().slideToggle();

	$(this).toggleClass('plus');
	$(this).toggleClass('minus');
	$(this).parent().toggleClass('color_titile');

});



