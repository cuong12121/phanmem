$('.videos_block_body .video_item .video_item_inner_has_img').click(function(){
	var img_video = $(this).find('img');
	var link_video = img_video.attr('link-video');
	console.log(link_video);
	var video = '<iframe src="'+ link_video +'"></iframe>';
//	$(this).find('.video_item_inner').html(video);
$(this).html('<iframe src="'+link_video+'?rel=0&autoplay=1" width="100%"  frameborder="0" allowfullscreen="false">');
$(this).removeClass('video_item_inner_has_img');
//	console.log(video);
//	img_video.replace(video); 
});

$(function() {
	$('.videos_block_body_body .item_video').removeClass('hiden');
	$('.videos_block_body_body .item_video').removeClass('item_video2');
	$('.video_slide').owlCarousel({
        items:1,
        merge:false,
        loop:true,
        margin:30,
        video:true,
        lazyLoad:true,
        // center:true,
        videoWidth: false,
        videoHeight: false,
        responsive:{
            300:{
                items:1,
                 margin:0
            },
            600:{
                items:2,
                 margin:20
            },
            800:{
                items:3,
                 margin:30

            }
        }
    })
});