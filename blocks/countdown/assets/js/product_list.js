$(document).ready(function(){	
	$(".product_list_slideshow").easySlider();
	var width=$('#product_list li').width();
	var height=$('#product_list li').height();
	var text=$('#product_list').attr('id');
	$('#nextBtn_'+text).css({'left':'1000px','top':height/2-17});
	$('#prevBtn_'+text).css({'top':height/2-17});
	$('#product_list').css({'margin':'0px auto'});
});	