$(document).ready( function(){
	$(".close_toc").click(function () {
		if($('.all_toc').hasClass('height-toc')){
			$('.all_toc').removeClass('height-toc');
			$('.close_toc').html('-').removeClass('fix-close-toc');
		}else {
			$('.all_toc').addClass('height-toc');
			$('.close_toc').html('+').addClass('fix-close-toc');
			
		}	
	})
});