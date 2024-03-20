$('#one_video_play_area .video_item_inner_has_img').click(function(){
	var img_video = $(this).find('img');
	var link_video = img_video.attr('link-video');
	var video = '<iframe src="'+ link_video +'"></iframe>';
	var ifr_vi = '<iframe src="'+link_video+'?rel=0&autoplay=1" width="100%" height="325px" frameborder="0" allowfullscreen="false">';
	$(this).html(ifr_vi);
	$(this).removeClass('video_item_inner_has_img');
});

$(document).ready(function(){
	$('.button_in').click(function(){
		$('.description-bl').css('max-height','none');
		$('.button_in').css('display','none');
		$('.button_out').css('display','block');
	});	

	$('.button_out').click(function(){
		$('.description-bl').css('max-height','190px');
		$('.button_in').css('display','block');
		$('.button_out').css('display','none');
	});	

});	
