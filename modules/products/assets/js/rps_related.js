$(document).ready(function($){
	for(var j = 1;j<=3;j++){
		$('.product-relate-'+j+' .carousel ul').carouFredSel({
			prev: '.product-relate-'+j+' #prev',
			next: '.product-relate-'+j+' #next',
			pagination: '.product-relate-'+j+' #pager',
			scroll : {
	            items           : 1,
	            duration        : 1000,                         
	            pauseOnHover    : true
	        }    
		});
	}
	$( ".product-relate .carousel ul" ).removeClass('hidden');
});