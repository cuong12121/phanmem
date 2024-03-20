$(document).ready(function(){
	scroll_to_session();
}); 
function scroll_to_session(){

	
	
	$(window).scroll(function () {

		st = $(this).scrollTop();		
		var_spen_top = $('.feature-spen').offset().top;
		// console.log(st);
		//  console.log($('.feature-spen').offset().top);
		if(st >= (var_spen_top + 240) ){
			$('.feature-spen').addClass('hello');
		}else{
			$('.feature-spen').removeClass('hello');
		}

	});
}