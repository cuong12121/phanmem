function run_menu(){
	width_windown = $(document).width();
	if(width_windown > 767){
		$('.mainmenu-jellyfish .item').mouseenter(function(){
			$('.sub-activated').css('display','none');
			$(this).find('.menus_level_1').css('display','block');
		}).mouseleave(function(){
			$(this).find('.menus_level_1').css('display','none');
			$('.sub-activated').css('display','none');
		});	
	}else{
		$('.mainmenu-jellyfish .item').click(function(){
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
        $(".has_children").hover(function(){
            $ac=$(this);
            $left=($ac.children(".menus_level_1").width())/2;
            $li=($ac.width())/2;
            $ac.children(".menus_level_1").css("left",-($left-$li));
        });
});