function run_menu(){
	width_windown = $(document).width();
	if(width_windown > 767){
		$('.mainmenu-tiepthitieudung .item').mouseenter(function(){
			$('.sub-activated').css('display','none');
			$(this).find('.menus_level_1').css('display','block');
		}).mouseleave(function(){
			$(this).find('.menus_level_1').css('display','none');
			$('.sub-activated').css('display','none');
		});	
	}else{
		$('.mainmenu-tiepthitieudung .item').click(function(){
			if($('.menus_level_1').hasClass('block')){
				$('.sub-activated').css('display','none');	
			}else{
				$('.sub-activated').css('display','block');
			}
		});
	}
	
}
$( document ).ready(function() {
	run_menu();
});