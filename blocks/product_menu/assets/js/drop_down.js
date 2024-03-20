$( document ).ready(function() {
	$('#product_menu_ul .view_all').click(function(){
		$('#product_menu_ul >ul').toggleClass('height_auto');
		$(this).toggleClass('position_auto'); 
	});
});