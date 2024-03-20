$(function() {
	$('#carousel ul').carouFredSel({
		direction   : "right",
		circular: true,
	    infinite: true,
	    auto    :{
	    	duration    : 2000,
	        timeoutDuration: 3000,
	        pauseOnHover: true
	        },
//	    auto:false,
		prev: '#prev',
		next: '#next',
		pagination: "#pager",
		scroll: 3000
	});
	

});
//$(document).ready(function() {
//	$('#carousel ul li a img').each(function(){
//		if(/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())){
//			$("#carousel ul li img").load(function(){
//			var width = $(this).width();
			
//			console.log("width = " + width );
//		});
//		}else{
//			aimgcopy = $(this).clone();
//			$('#store').append(aimgcopy);
//
//			console.log('Height: '+aimgcopy.height()+' Width: '+aimgcopy.width());
//
//			$(this).parent().parent().css("width", aimgcopy.width()+ 20 +"px");
//			console.log($(this).width());
//			$(this).parent().parent().css("width", $(this).width() + "px");
//		} 	
//	});
	

//});
