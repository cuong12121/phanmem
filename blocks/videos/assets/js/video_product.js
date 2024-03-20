$('.video_product .video_product_inner_has_img').click(function(){
	//var img_video = $(this).find('img');
	var link_video = $(this).attr('link-video');
	console.log(link_video);
	var video = '<iframe src="'+ link_video +'"></iframe>';
//	$(this).find('.video_item_inner').html(video);
	$(this).html('<iframe src="'+link_video+'?rel=0&autoplay=1" width="100%" height="100%" frameborder="0" allowfullscreen="false">');
	$(this).removeClass('video_product_inner_has_img');
//	console.log(video);
//	img_video.replace(video); 
});