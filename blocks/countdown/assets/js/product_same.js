$(document).ready(function(){	
	$("#product_same").easySlider();
//	var width=$('#product_same li').width();
//	var height=$('#product_same li').height();
	
	var width=752;
	var height=220;
	var text=$('#product_same').attr('id');
	$("#product_same").css({'height':'222px'});
	$('#nextBtn_'+text).css({'left':'880px','top':height/2-58});
	$('#prevBtn_'+text).css({'left':'40px','top':height/2-58});
	$('#product_same').css({'margin':'0px auto'});
});	