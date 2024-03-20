
$(document).ready(function(){
	product_menu();
});	

function product_menu(){
	$('#product_select').click(function(){
		if($(this).hasClass('close')){
			$(this).removeClass("close");
			$(this).addClass("open");
			$(this).next("ul").stop(true,true).show(200);
		}else{
			$(this).addClass("close");
			$(this).removeClass("open");
			$(this).next("ul").hide(200);
		}
	});
}
