$(document).ready(function(){	
	$('#partners ul').show();
	$("#partners").easySlider({
		element: 'li',
		auto:			false
	});
	var width=$('#partners li').width();
	var height=$('#partners li').height();
	var text=$('#partners').attr('id');
	$('#partners').css({'margin':'0px auto'});
});	