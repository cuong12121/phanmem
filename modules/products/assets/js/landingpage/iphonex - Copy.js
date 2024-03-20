$(document).ready(function(){
	scroll_to_session();
}); 
function scroll_to_session(){

	
	
	$(window).scroll(function () {

		st = $(this).scrollTop();		
		var section2_top = $('.section2').offset().top;
		var section2_height = $('.section2').height() ;
		var section2_bottom = section2_top + section2_height ;
		var max_transf = 90;
		var top_transf = 0;
		var section2_content_top = section2_top + top_transf;

		
		 console.log(st);
		  console.log(section2_content_top);
		if(st < section2_content_top){
			$('#design_display').css({'transform' : 'translate(' + 0 +'px, ' + max_transf + 'px)'})
		}else{
			if(st <= section2_bottom){
				var transf = max_transf - (((st - section2_content_top)/section2_height) * max_transf);
				$('#design_display').css({'transform' : 'translate(' + 0 +'px, ' + transf + 'px)'})	
			}else{
				$('#design_display').css({'transform' : 'translate(' + 0 +'px, ' + 0 + 'px)'})	
			}
		}


		section2
		
	});
}

function scroll_transfrom(element, top,height,max_transf,top_transf){
	
}