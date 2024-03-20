function popup_video_full(link_video) {
	console.log(link_video);
	$('.popup-video-full').show();
	var video = '<iframe src="'+ link_video +'"></iframe>';
	$('.popup-video-full .video').html('<iframe allow="autoplay" src="'+link_video+'?rel=0&autoplay=1" width="98%" height="224px" frameborder="0" allowfullscreen="false">');
}

function close_popup_video_full(){
	$('.popup-video-full').hide();
	$('.popup-video-full .video').html('');
}
